<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function index(Request $request)
    {
        $sessionId = $request->attributes->get('session_id', $request->cookie('session_id'));

        $projects = Project::where('session_id', $sessionId)
            ->orWhere('local_storage_key', $request->input('local_storage_key'))
            ->with('template')
            ->get();

        return Inertia::render('Dashboard', [
            'projects' => $projects,
            'templates' => \App\Models\Template::all(),
        ]);
    }

    public function store(Request $request)
    {
        $sessionId = $request->attributes->get('session_id', $request->cookie('session_id'));

        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'project_name' => 'required|string|max:255',
            'settings_json' => 'required|array',
            'local_storage_key' => 'nullable|string',
        ]);

        $project = Project::create([
            'session_id' => $sessionId,
            'local_storage_key' => $request->input('local_storage_key'),
            'template_id' => $request->template_id,
            'project_name' => $request->project_name,
            'settings_json' => $request->settings_json,
        ]);

        $this->analytics->trackTemplateSelection($sessionId, $request->template_id);

        return redirect()->route('projects.edit', $project->id);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Editor', [
            'project' => $project->load('template'),
            'templates' => \App\Models\Template::all(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'project_name' => 'sometimes|string|max:255',
            'settings_json' => 'sometimes|array',
        ]);

        $project->update($request->only(['project_name', 'settings_json']));

        return response()->json(['message' => 'Project saved successfully']);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('dashboard');
    }
}
