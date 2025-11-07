<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index($taskId)
    {
        $comments = Comment::where('task_id', $taskId)->get();
        return response()->json($comments, 200);
    }

    public function store(Request $request, $taskId)
    {
        $validated = $request->validate([
            'body' => 'required|string'
        ]);

        $comment = Comment::create([
            'task_id'   => $taskId,
            'author_id' => $request->user()->id,
            'body'      => $validated['body']
        ]);

        return response()->json($comment, 201);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->author_id !== $request->user()->id) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted'], 200);
    }
}
