<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('assignee_id')) {
            $query->where('assignee_id', $request->assignee_id);
        }
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->get();
        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'title'        => 'required|string',
            'description'  => 'nullable|string',
            'status'       => 'required|string',
            'priority'     => 'required|string',
            'due_date'     => 'nullable|date'
        ]);

        $validated['author_id'] = $request->user()->id;

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return response()->json($task, 200);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->author_id !== $request->user()->id && $task->project->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $validated = $request->validate([
            'title'       => 'string',
            'description' => 'nullable|string',
            'status'      => 'string',
            'priority'    => 'string',
            'due_date'    => 'nullable|date'
        ]);

        $task->update($validated);

        return response()->json($task, 200);
    }

    public function destroy(Request $request, Task $task)
    {
        if ($task->author_id !== $request->user()->id && $task->project->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted'], 200);
    }
}
