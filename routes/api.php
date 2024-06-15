<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\GroupMemberController;
use App\Http\Controllers\Api\TaskListController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\SubtaskController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AttachmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('users', UserController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('group_members', GroupMemberController::class);
Route::apiResource('task_lists', TaskListController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('subtasks', SubtaskController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('attachments', AttachmentController::class);
