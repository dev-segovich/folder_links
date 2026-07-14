<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\TicketSubtask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /** Whether the token's user may see items hidden from the boss (Rey). */
    protected function seesHidden(Request $request): bool
    {
        return $request->user()->isDev();
    }

    /** Block boss tokens from any ticket hidden from him. */
    protected function guardTicket(Request $request, Ticket $ticket): void
    {
        if (! $this->seesHidden($request) && ! $ticket->isVisibleToBoss()) {
            abort(404, 'Ticket no encontrado.');
        }
    }

    public function index(Request $request)
    {
        $query = Ticket::query()
            ->with(['project', 'creator', 'assignee'])
            ->when(! $this->seesHidden($request), fn ($q) => $q->visibleToBoss())
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }
        foreach (['project' => 'project_id', 'status' => 'status', 'priority' => 'priority'] as $param => $column) {
            if ($request->filled($param)) {
                $query->where($column, $request->input($param));
            }
        }

        return response()->json($query->paginate(min((int) $request->input('per_page', 20), 100)));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|in:baja,media,alta,critica',
            'status' => 'nullable|in:backlog,en_progreso,en_revision,done',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'visible_from_boss' => 'nullable|boolean',
        ]);

        $ticket = Ticket::create(array_merge($validated, [
            'created_by' => $request->user()->id,
            'status' => $validated['status'] ?? 'backlog',
            // Only a dev token may hide a ticket from the boss.
            'visible_from_boss' => $this->seesHidden($request) ? ($validated['visible_from_boss'] ?? true) : true,
        ]));

        return response()->json($ticket->load(['project', 'creator', 'assignee']), 201);
    }

    public function show(Request $request, Ticket $ticket)
    {
        $this->guardTicket($request, $ticket);

        return response()->json(
            $ticket->load(['project', 'creator', 'assignee', 'comments.user', 'subtasks', 'files', 'auditLogs.performer'])
        );
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->guardTicket($request, $ticket);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:backlog,en_progreso,en_revision,done',
            'priority' => 'required|in:baja,media,alta,critica',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date',
            'visible_from_boss' => 'nullable|boolean',
        ]);

        if (! $this->seesHidden($request)) {
            unset($validated['visible_from_boss']);
        }

        $oldStatus = $ticket->status;
        $oldPriority = $ticket->priority;
        $ticket->update($validated);

        if ($oldStatus !== $ticket->status) {
            $this->log($ticket, $request, 'status_changed', "Estado cambiado de '{$oldStatus}' a '{$ticket->status}'");
        }
        if ($oldPriority !== $ticket->priority) {
            $this->log($ticket, $request, 'priority_changed', "Prioridad cambiada a '{$ticket->priority}'");
        }

        return response()->json($ticket->load(['project', 'creator', 'assignee']));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $this->guardTicket($request, $ticket);

        $validated = $request->validate([
            'status' => 'required|in:backlog,en_progreso,en_revision,done',
        ]);

        $oldStatus = $ticket->status;
        if ($oldStatus !== $validated['status']) {
            $ticket->update(['status' => $validated['status']]);
            $this->log($ticket, $request, 'status_changed', "Estado cambiado de '{$oldStatus}' a '{$validated['status']}'");
        }

        return response()->json($ticket);
    }

    public function destroy(Request $request, Ticket $ticket)
    {
        $this->guardTicket($request, $ticket);

        Storage::disk('public')->deleteDirectory("tickets/{$ticket->id}");
        $ticket->delete();

        return response()->json(['message' => 'Ticket eliminado.']);
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $this->guardTicket($request, $ticket);

        $validated = $request->validate(['message' => 'required|string']);

        $comment = $ticket->comments()->create([
            'message' => $validated['message'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function destroyComment(Request $request, Ticket $ticket, TicketComment $comment)
    {
        $this->guardTicket($request, $ticket);

        if ($comment->ticket_id !== $ticket->id || $request->user()->id !== $comment->user_id) {
            abort(403, 'No puede eliminar este comentario.');
        }

        $this->log($ticket, $request, 'comment_deleted', 'Comentario eliminado');
        $comment->delete();

        return response()->json(['message' => 'Comentario eliminado.']);
    }

    public function storeSubtask(Request $request, Ticket $ticket)
    {
        $this->guardTicket($request, $ticket);

        $validated = $request->validate(['title' => 'required|string|max:255']);

        $subtask = $ticket->subtasks()->create([
            'title' => $validated['title'],
            'sort_order' => $ticket->subtasks()->count() + 1,
        ]);

        return response()->json($subtask, 201);
    }

    public function toggleSubtask(Request $request, Ticket $ticket, TicketSubtask $subtask)
    {
        $this->guardTicket($request, $ticket);

        if ($subtask->ticket_id !== $ticket->id) {
            abort(404);
        }

        $subtask->update(['completed' => ! $subtask->completed]);

        return response()->json($subtask);
    }

    public function destroySubtask(Request $request, Ticket $ticket, TicketSubtask $subtask)
    {
        $this->guardTicket($request, $ticket);

        if ($subtask->ticket_id !== $ticket->id) {
            abort(404);
        }

        $this->log($ticket, $request, 'subtask_deleted', "Subtarea eliminada: {$subtask->title}");
        $subtask->delete();

        return response()->json(['message' => 'Subtarea eliminada.']);
    }

    protected function log(Ticket $ticket, Request $request, string $action, string $details): void
    {
        AuditLog::create([
            'ticket_id' => $ticket->id,
            'action' => $action,
            'performed_by' => $request->user()->id,
            'details' => $details,
        ]);
    }
}
