<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\TaskController\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/allUsers', [UserController::class, 'getAllUsers']);
    Route::get('/showUser/{user}', [UserController::class, 'showUser']);
    Route::put('/updateUser', [UserController::class, 'updateUser']);

    Route::get('/getTasksGroupByStatus', [TaskController::class, 'getTasksGroupByStatus']);

    Route::group(['middleware' => ['role:programmer']], function () {
        Route::get('/allTasks', [TaskController::class, 'getAllTasks']);
        Route::get('/showTask/{id}', [TaskController::class, 'showTask']);
    });

    Route::group(['middleware' => ['role:manager']], function () {
        Route::post('assignUser/{task}', [TaskController::class, 'assignUser']);
        Route::post('unassignUser/{task}', [TaskController::class, 'unassignUser']);
        Route::post('assignRole/{user}', [UserController::class, 'assignRole']);
        Route::post('removeRole/{user}', [UserController::class, 'removeRole']);
        Route::delete('/deleteUser/{id}', [UserController::class, 'deleteUser']);
        Route::put('/updateTask', [TaskController::class, 'updateTask']);
        Route::delete('/deleteTask', [TaskController::class, 'deleteTask']);
    });

    Route::group(['middleware' => ['limit.request']], function () {
        Route::post('/createTask', [TaskController::class, 'createTask']);
    });
});
