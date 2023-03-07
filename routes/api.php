<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Todo\TaskController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Todo\TodoListController;

Route::group(['prefix' => 'v1'], function () {

    /**
     * User authentication
     */
    Route::controller(UserController::class)->group(function () {
        Route::post('user-register', 'register');
        Route::post('user-login', 'login');
        Route::get('user-logout', 'logout');
        Route::get('token-refresh', 'refresh');
    });
    /**
     * Auth guard protected routes
     */
    Route::group(['middleware' => 'auth:jwt-auth'], function () {

        /**
         * To Do Lists
         */
        Route::controller(TodoListController::class)->group(function () {
            Route::post('store-list', 'store');
            Route::post('get-to-do-lists', 'todoLists');
            Route::post('update-list', 'updateList');
            Route::post('delete-list', 'deleteList');
        });
        /**
         * Tasks
         */
        Route::controller(TaskController::class)->group(function () {
            Route::post('store-task', 'store');
            Route::post('task-lists', 'taskList');
            Route::post('delete-task', 'deleteTask');
            Route::post('update-task', 'updateTask');
            Route::post('change-task-status', 'changeTaskStatus');
        });
    });
});
