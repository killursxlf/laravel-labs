<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class CommentCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment->loadMissing('task', 'author');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('project.' . $this->comment->task->project_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'comment.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id'        => $this->comment->id,
            'task_id'   => $this->comment->task_id,
            'body'      => $this->comment->body,
            'author'    => optional($this->comment->author)->name,
            'project_id'=> $this->comment->task->project_id,
        ];
    }
}
