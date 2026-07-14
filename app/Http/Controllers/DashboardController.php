<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Guests browse as the jefe and only see tickets visible to him.
        $ticketScope = fn ($q) => $q->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss());

        $activeTickets = $ticketScope(Ticket::whereIn('status', ['backlog', 'en_progreso', 'en_revision']))->count();
        $inProgressTickets = $ticketScope(Ticket::where('status', 'en_progreso'))->count();
        $inReviewTickets = $ticketScope(Ticket::where('status', 'en_revision'))->count();

        $projects = Project::query()
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->with('links')
            ->get();

        // Get recent tickets (last 10 modified)
        $recentTickets = Ticket::with(['project', 'creator', 'assignee'])
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->latest()
            ->take(10)
            ->get();

        $env = $request->input('env', 'prod');

        return view('dashboard.index', compact(
            'projects',
            'activeTickets',
            'inProgressTickets',
            'inReviewTickets',
            'recentTickets',
            'env'
        ));
    }
}
