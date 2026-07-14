<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\TicketSubtask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Guests browse as the jefe: block them from any ticket hidden from him.
     */
    protected function guardTicket(Ticket $ticket): void
    {
        if (! can_see_hidden() && ! $ticket->isVisibleToBoss()) {
            abort(404);
        }
    }

    public function show(Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $ticket->load(['project', 'creator', 'assignee', 'comments.user', 'subtasks', 'files', 'auditLogs.performer']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $projects = Project::query()
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->get();

        return view('tickets.create', compact('ticket', 'projects'));
    }

    public function destroy(Ticket $ticket)
    {
        $this->guardTicket($ticket);

        Storage::disk('public')->deleteDirectory("tickets/{$ticket->id}");
        $ticket->delete();

        return redirect()->route('tickets.index');
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:backlog,en_progreso,en_revision,done',
            'priority' => 'required|in:baja,media,alta,critica',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date',
            'visible_from_boss' => 'nullable|boolean',
        ]);

        // Only the logged-in dev may change a ticket's visibility to the jefe.
        if (! can_see_hidden()) {
            unset($validated['visible_from_boss']);
        }

        $oldStatus = $ticket->status;

        $ticket->update($validated);

        if ($oldStatus !== $validated['status']) {
            AuditLog::create([
                'ticket_id' => $ticket->id,
                'action' => 'status_changed',
                'performed_by' => acting_user()->id,
                'details' => "Estado cambiado de '{$oldStatus}' a '{$validated['status']}'",
            ]);
        }

        if (isset($validated['priority']) && $ticket->getOriginal('priority') !== $validated['priority']) {
            AuditLog::create([
                'ticket_id' => $ticket->id,
                'action' => 'priority_changed',
                'performed_by' => acting_user()->id,
                'details' => "Prioridad cambiada a '{$validated['priority']}'",
            ]);
        }

        return redirect()->route('tickets.show', $ticket);
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $validated = $request->validate([
            'status' => 'required|in:backlog,en_progreso,en_revision,done',
        ]);

        $oldStatus = $ticket->status;

        if ($oldStatus !== $validated['status']) {
            $ticket->update(['status' => $validated['status']]);

            AuditLog::create([
                'ticket_id' => $ticket->id,
                'action' => 'status_changed',
                'performed_by' => acting_user()->id,
                'details' => "Estado cambiado de '{$oldStatus}' a '{$validated['status']}'",
            ]);
        }

        return redirect()->route('tickets.show', $ticket);
    }

    public function storeSubtask(Request $request, Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $subtask = $ticket->subtasks()->create(array_merge($validated, [
            'sort_order' => $ticket->subtasks()->count() + 1,
        ]));

        return redirect()->route('tickets.show', $ticket);
    }

    public function toggleSubtask(Ticket $ticket, TicketSubtask $subtask)
    {
        $this->guardTicket($ticket);

        if ($subtask->ticket_id !== $ticket->id) {
            abort(404);
        }

        $subtask->update(['completed' => ! $subtask->completed]);

        return redirect()->route('tickets.show', $ticket);
    }

    public function destroySubtask(Ticket $ticket, TicketSubtask $subtask)
    {
        $this->guardTicket($ticket);

        if ($subtask->ticket_id !== $ticket->id) {
            abort(404);
        }

        AuditLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'subtask_deleted',
            'performed_by' => acting_user()->id,
            'details' => "Subtarea eliminada: {$subtask->title}",
        ]);

        $subtask->delete();

        return redirect()->route('tickets.show', $ticket);
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->comments()->create(array_merge($validated, [
            'user_id' => acting_user()->id,
        ]));

        return redirect()->route('tickets.show', $ticket);
    }

    public function destroyComment(Ticket $ticket, TicketComment $comment)
    {
        $this->guardTicket($ticket);

        if ($comment->ticket_id !== $ticket->id || acting_user()->id !== $comment->user_id) {
            abort(403);
        }

        AuditLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'comment_deleted',
            'performed_by' => acting_user()->id,
            'details' => 'Comentario eliminado',
        ]);

        $comment->delete();

        return redirect()->route('tickets.show', $ticket);
    }

    public function storeFile(Request $request, Ticket $ticket)
    {
        $this->guardTicket($ticket);

        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store("tickets/{$ticket->id}", 'public');

        $file = $ticket->files()->create([
            'filename' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            'uploaded_by' => acting_user()->id,
        ]);

        AuditLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'file_uploaded',
            'performed_by' => acting_user()->id,
            'details' => "Archivo subido: {$file->filename}",
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    public function downloadFile(Ticket $ticket, string $file)
    {
        $this->guardTicket($ticket);

        $ticketFile = $ticket->files()->where('path', $file)->first();

        if (! $ticketFile) {
            abort(404);
        }

        return Storage::disk('public')->download($ticketFile->path, $ticketFile->filename);
    }

    public function destroyFile(Ticket $ticket, string $file)
    {
        $this->guardTicket($ticket);

        $ticketFile = $ticket->files()->where('path', $file)->first();

        if (! $ticketFile || acting_user()->id !== $ticketFile->uploaded_by) {
            abort(403);
        }

        AuditLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'file_deleted',
            'performed_by' => acting_user()->id,
            'details' => "Archivo eliminado: {$ticketFile->filename}",
        ]);

        Storage::disk('public')->delete($ticketFile->path);
        $ticketFile->delete();

        return redirect()->route('tickets.show', $ticket);
    }
}
