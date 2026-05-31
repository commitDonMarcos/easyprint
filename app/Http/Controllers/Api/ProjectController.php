<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $sessionId = $request->header('X-Session-Id', $request->input('session_id'));

        $projects = Project::where('session_id', $sessionId)
            ->orWhere('local_storage_key', $request->input('local_storage_key'))
            ->with('template')
            ->orderBy('created_at', 'desc')
            ->get();

        return ProjectResource::collection($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $sessionId = $request->header('X-Session-Id', $request->input('session_id'));

        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'project_name' => 'required|string|max:255',
            'settings_json' => 'required|array',
            'local_storage_key' => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            'session_id' => $sessionId,
            'local_storage_key' => $validated['local_storage_key'] ?? null,
            'template_id' => $validated['template_id'],
            'project_name' => $validated['project_name'],
            'settings_json' => $validated['settings_json'],
        ]);

        $this->analytics->trackTemplateSelection($sessionId, $validated['template_id']);

        return response()->json([
            'message' => 'Project created successfully.',
            'project' => new ProjectResource($project->load('template')),
        ], 201);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'project_name' => 'sometimes|string|max:255',
            'settings_json' => 'sometimes|array',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully.',
            'project' => new ProjectResource($project->load('template')),
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();
        
        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
