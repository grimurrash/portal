<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Management\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
           Route::post('create', [UserController::class, 'createUser'])->name('create');
        });
    });
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('user', [AuthController::class, 'user'])->name('user');
    });
});
