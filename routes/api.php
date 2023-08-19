<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Management\DepartmentController;
use App\Http\Controllers\Management\EmployeeController;
use App\Http\Controllers\Management\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
//        Route::resource('users', UserController::class);
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::post('create', [UserController::class, 'create'])->name('create');
            Route::get('index', [UserController::class, 'index'])->name('index');
        });

        Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
           Route::get('', [DepartmentController::class, 'index'])->name('list');
           Route::get('parent-department-options', [DepartmentController::class, 'parentDepartmentOptions'])->name('parent-department-options');
           Route::get('all-department-options', [DepartmentController::class, 'allDepartmentOptions'])->name('all-department-options');
           Route::put('{id}/update', [DepartmentController::class, 'update'])->name('update');
           Route::delete('{id}/delete', [DepartmentController::class, 'destroy'])->name('delete');
        });

        Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
            Route::get('/', [EmployeeController::class, 'list'])->name('list');
            Route::get('/options-by-department', [EmployeeController::class, 'optionsByDepartment'])->name('options-by-department');
            Route::post('import', [EmployeeController::class, 'import'])->name('import');
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
