<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected function seesHidden(Request $request): bool
    {
        return $request->user()->isDev();
    }

    public function index(Request $request)
    {
        $seesHidden = $this->seesHidden($request);

        $projects = Project::query()
            ->with('links')
            ->when(! $seesHidden, fn ($q) => $q->visibleToBoss())
            ->get()
            ->map(fn (Project $p) => $this->withCounts($p, $seesHidden));

        return response()->json($projects);
    }

    public function show(Request $request, Project $project)
    {
        $seesHidden = $this->seesHidden($request);

        if (! $seesHidden && ! $project->isVisibleToBoss()) {
            abort(404, 'Proyecto no encontrado.');
        }

        return response()->json($this->withCounts($project->load('links'), $seesHidden));
    }

    /** Ticket counts respecting the token's visibility (boss tokens ignore hidden tickets). */
    protected function withCounts(Project $project, bool $seesHidden): Project
    {
        $base = fn () => $project->tickets()->when(! $seesHidden, fn ($q) => $q->visibleToBoss());

        $project->setAttribute('active_tickets', (clone $base())->whereIn('status', ['backlog', 'en_progreso', 'en_revision'])->count());
        $project->setAttribute('completed_tickets', (clone $base())->where('status', 'done')->count());

        return $project;
    }
}
