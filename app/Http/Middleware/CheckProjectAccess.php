<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Project;

class CheckProjectAccess
{
    public function handle(Request $request, Closure $next, $role = 'member')
    {
        $project = $request->route('project');

        if (! $project instanceof \App\Models\Project) {
            $projectId = $request->route('project')
                        ?? $request->route('id');
            $project = \App\Models\Project::find($projectId);
        }

        if (! $project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $user = $request->user();

        $isOwner  = $project->owner_id === $user->id;
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
