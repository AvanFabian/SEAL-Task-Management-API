<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/avatar', [UserController::class, 'uploadAvatar']);

    // Project routes
    Route::apiResource('projects', ProjectController::class);

    // Task routes
    Route::apiResource('tasks', TaskController::class);
});