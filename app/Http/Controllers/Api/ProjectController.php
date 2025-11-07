<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()->get();
        return response()->json($projects, 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string'
            ]);

            $project = $request->user()->projects()->create([
                'name' => $validated['name']
            ]);

            return response()->json($project, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create project'], 500);
        }
    }

    public function show(Project $project)
    {
        try {
            return response()->json($project, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }

    public function update(Request $request, Project $project)
    {
        if ($project->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string'
            ]);

            $project->update(['name' => $validated['name']]);
            return response()->json($project, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update project'], 500);
        }
    }

    public function destroy(Request $request, Project $project)
    {
        if ($project->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        try {
            $project->delete();
            return response()->json(['message' => 'Project deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete project'], 500);
        }
    }
}
