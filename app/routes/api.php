<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\UserController\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['middleware' => ['role:programmer']], function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/allUsers', [UserController::class, 'getAllUsers']);
        Route::get('/showUser/{user}', [UserController::class, 'showUser']);
        Route::put('/updateUser', [UserController::class, 'updateUser']);

        Route::post('assignRole/{user}', [UserController::class, 'assignRole']);
        Route::post('removeRole/{user}', [UserController::class, 'removeRole']);
        Route::delete('/deleteUser/{id}', [UserController::class, 'deleteUser']);
    });
});
