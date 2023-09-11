<?php

use App\Http\Controllers\Activity\OrganizationProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Management\DepartmentController;
use App\Http\Controllers\Management\EmployeeController;
use App\Http\Controllers\Management\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::post('create', [UserController::class, 'create'])->name('create');
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('index', [UserController::class, 'index'])->name('list');
            Route::post('create', [UserController::class, 'create'])->name('create');
            Route::get('{id}/show', [UserController::class, 'show'])->name('show');
            Route::put('{id}/update', [UserController::class, 'update'])->name('update');
            Route::delete('{id}/delete', [UserController::class, 'destroy'])->name('delete');
            Route::get('options', [UserController::class, 'options'])->name('options');
        });

        Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
            Route::get('', [DepartmentController::class, 'index'])->name('list');
            Route::get('parent-department-options', [DepartmentController::class, 'parentDepartmentOptions'])->name(
                'parent-department-options'
            );
            Route::get('all-department-options', [DepartmentController::class, 'allDepartmentOptions'])->name(
                'all-department-options'
            );
            Route::put('{id}/update', [DepartmentController::class, 'update'])->name('update');
            Route::delete('{id}/delete', [DepartmentController::class, 'destroy'])->name('delete');
        });

        Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
            Route::get('/', [EmployeeController::class, 'list'])->name('list');
            Route::get('/options-by-department', [EmployeeController::class, 'optionsByDepartment'])
                ->name('options-by-department');
            Route::post('import', [EmployeeController::class, 'import'])->name('import');
        });
    });

    Route::group(['prefix' => 'activity', 'as' => 'activity.'], function () {
        Route::group(['prefix' => 'organization-projects', 'as' => 'organization-projects.'], function () {
            Route::post('create', [OrganizationProjectController::class, 'create'])->name('create');
            Route::get('list', [OrganizationProjectController::class, 'mainList'])->name('list');
            Route::get('general-list', [OrganizationProjectController::class, 'generalList'])->name('general-list');
            Route::get('moderate-list', [OrganizationProjectController::class, 'moderateList'])->name('moderate-list');
            Route::get('calendar', [OrganizationProjectController::class, 'calendar'])->name('calendar');

            Route::group(['prefix' => '{organizationProject}'], function () {
                Route::get('', [OrganizationProjectController::class, 'show'])->name('show');
                Route::put('post-for-moderation', [OrganizationProjectController::class, 'sendForModeration'])
                    ->name('post-for-moderation');
                Route::put('moderate', [OrganizationProjectController::class, 'moderate'])->name('moderate');
                Route::put('approve', [OrganizationProjectController::class, 'approve'])->name('approve');
            });
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
