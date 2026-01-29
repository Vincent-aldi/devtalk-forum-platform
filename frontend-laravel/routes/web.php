<?php
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ForumController::class, 'index']);
Route::post('/join', [ForumController::class, 'register']);
Route::post('/comment', [ForumController::class, 'postComment']);
Route::patch('/comment/{id}', [ForumController::class, 'updateComment']);
Route::delete('/comment/{id}', [ForumController::class, 'deleteComment']);