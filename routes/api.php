<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Middleware\CheckProjectAccess;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{project}', [ProjectController::class, 'show'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->middleware(CheckProjectAccess::class . ':owner');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->middleware(CheckProjectAccess::class . ':owner');

    Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
        ->middleware(CheckProjectAccess::class . ':member');

    Route::get('/tasks/{task}/comments', [CommentController::class, 'index'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])
        ->middleware(CheckProjectAccess::class . ':member');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->middleware(CheckProjectAccess::class . ':member');
});
