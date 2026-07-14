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

        // Heatmap: 52 weeks of activity, one bucket per day, two selectable metrics.
        // Grid starts on a Monday so the columns line up as whole weeks.
        $heatmapStart = now()->startOfWeek()->subWeeks(51);
        $heatmapEnd = now()->endOfDay();

        // `assigned_at` / `completed_at` are stamped by the Ticket model on transition,
        // so a day's bucket is the day the work actually happened.
        $countByDay = fn ($query, string $column) => $ticketScope($query)
            ->whereBetween($column, [$heatmapStart, $heatmapEnd])
            ->selectRaw("DATE({$column}) as day, COUNT(*) as total")
            ->groupBy('day')
            ->pluck('total', 'day')
            ->map(fn ($total) => (int) $total)
            ->all();

        $heatmap = [
            'start' => $heatmapStart->toDateString(),
            'end' => now()->toDateString(),
            'default' => 'completed',
            'metrics' => [
                'completed' => [
                    'label' => 'Completados',
                    'singular' => 'ticket completado',
                    'plural' => 'tickets completados',
                    'counts' => $countByDay(Ticket::where('status', 'done'), 'completed_at'),
                ],
                'assigned' => [
                    'label' => 'Asignados',
                    'singular' => 'ticket asignado',
                    'plural' => 'tickets asignados',
                    'counts' => $countByDay(Ticket::whereNotNull('assigned_to'), 'assigned_at'),
                ],
            ],
        ];

        $env = $request->input('env', 'prod');

        return view('dashboard.index', compact(
            'projects',
            'activeTickets',
            'inProgressTickets',
            'inReviewTickets',
            'recentTickets',
            'heatmap',
            'env'
        ));
    }
}
