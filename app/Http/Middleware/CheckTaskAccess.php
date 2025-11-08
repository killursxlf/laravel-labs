<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Task;

class CheckTaskAccess
{
    public function handle(Request $request, Closure $next, $role = 'member')
    {
        $task = $request->route('task');

        if (! $task instanceof Task) {
            $taskId = $request->route('task') ?? $request->route('id');
            $task = Task::find($taskId);
        }

        if (! $task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $project = $task->project;
        if (! $project) {
            return response()->json(['message' => 'Project for task not found'], 404);
        }

        $user = $request->user();

        $isOwner  = ($project->owner_id === $user->id);
        $isMember = $project->users()->where('users.id', $user->id)->exists();

        if ($role === 'owner' && ! $isOwner) {
            return response()->json(['message' => 'Access denied (owner only)'], 403);
        }

        if ($role === 'member' && ! $isOwner && ! $isMember) {
            return response()->json(['message' => 'Access denied (not a project member)'], 403);
        }

        return $next($request);
    }
}
