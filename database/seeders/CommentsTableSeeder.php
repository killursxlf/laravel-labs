<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Comment::truncate();

        $comments = [
            ['task_id' => 1, 'author_id' => 2, 'body' => 'Great job! The structure looks clean.'],
            ['task_id' => 1, 'author_id' => 1, 'body' => 'Please add more details to the description.'],
            ['task_id' => 2, 'author_id' => 3, 'body' => 'I will review it later today.'],
            ['task_id' => 3, 'author_id' => 4, 'body' => 'UI design is in progress.'],
            ['task_id' => 4, 'author_id' => 5, 'body' => 'API integration was successful.'],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
