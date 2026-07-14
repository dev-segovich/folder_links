<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query()
            ->with(['project', 'creator', 'assignee'])
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        if ($request->filled('project')) {
            $query->where('project_id', $request->project);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'deadline':
                    $query->orderByRaw('deadline IS NULL, deadline ASC');
                    break;
                case 'priority':
                    $query->orderByRaw("FIELD(priority, 'critica', 'alta', 'media', 'baja')");
                    break;
                case 'created_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->latest();
            }
        }

        $tickets = $query->paginate(20);

        $projects = Project::query()
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->get();

        $env = $request->input('env', 'prod');

        return view('tickets.index', compact('tickets', 'projects', 'env'));
    }

    public function create()
    {
        $projects = Project::query()
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->get();

        return view('tickets.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|in:baja,media,alta,critica',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'visible_from_boss' => 'nullable|boolean',
        ]);

        $ticket = Ticket::create(array_merge($validated, [
            'created_by' => acting_user()->id,
            'status' => 'backlog',
            // Only the logged-in dev may hide a ticket from the jefe.
            'visible_from_boss' => can_see_hidden() ? ($validated['visible_from_boss'] ?? false) : true,
        ]));

        return redirect()->route('tickets.show', $ticket);
    }
}
