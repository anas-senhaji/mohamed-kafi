<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(\App\Http\Controllers\TeamController::class)->group(function () {
    Route::get('teams', 'index');
    Route::post('team', 'store');
    Route::get('team/{id}', 'show');
    Route::put('team/{id}', 'update');
    Route::delete('team/{id}', 'destroy');
});

Route::controller(\App\Http\Controllers\ProjectController::class)->group(function () {
    Route::get('projects', 'index');
    Route::post('project', 'store');
    Route::get('project/{id}', 'show');
    Route::put('project/{id}', 'update');
    Route::delete('project/{id}', 'destroy');
});

Route::controller(\App\Http\Controllers\TaskController::class)->group(function () {
    Route::get('tasks', 'index');
    Route::post('task', 'store');
    Route::get('task/{id}', 'show');
    Route::put('task/{id}', 'update');
    Route::delete('task/{id}', 'destroy');
});

