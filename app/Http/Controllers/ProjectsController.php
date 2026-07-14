<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    public function create()
    {
        abort_unless(can_see_hidden(), 403);

        return view('projects.create');
    }

    public function store(Request $request)
    {
        abort_unless(can_see_hidden(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'env' => 'nullable|in:prod,qa',
            'status' => 'nullable|string|max:100',
            'prod_url' => 'nullable|url|max:255',
            'local_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $validated['hidden_from_boss'] = $request->boolean('hidden_from_boss');

        Project::create($validated);

        return redirect()->route('projects.index');
    }

    public function index(Request $request)
    {
        $projects = Project::query()
            ->with('links')
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->get();

        $env = $request->input('env', 'prod');

        return view('projects.index', compact('projects', 'env'));
    }

    public function edit(Project $project)
    {
        abort_unless(can_see_hidden(), 403);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        abort_unless(can_see_hidden(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'env' => 'nullable|in:prod,qa',
            'status' => 'nullable|string|max:100',
            'prod_url' => 'nullable|url|max:255',
            'local_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['hidden_from_boss'] = $request->boolean('hidden_from_boss');

        $project->update($validated);

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        abort_unless(can_see_hidden(), 403);

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('projects.index');
    }
}
