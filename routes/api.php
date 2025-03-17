<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(\App\Http\Controllers\AuthController::class)
     ->prefix('auth')
     ->middleware(['api'])
     ->group(
         function () {
             Route::get('list-user', 'listUser');
             Route::post('login', 'login');
             Route::post('register', 'register');
             Route::post('refresh', 'refresh');
             Route::post('logout', 'logout');
         }
     );

Route::middleware(['jwtClient.auth'])->group(function () {
    Route::controller(\App\Http\Controllers\StudentController::class)->prefix('student')->group(
        function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );

    Route::controller(\App\Http\Controllers\SituationController::class)->prefix('situation')->group(
        function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );

    Route::controller(\App\Http\Controllers\SubjectController::class)->prefix('subject')->group(
        function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );

    Route::controller(\App\Http\Controllers\ClassroomController::class)->prefix('classroom')->group(
        function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );

    Route::controller(\App\Http\Controllers\MealController::class)->prefix('meal')->group(
        function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );

    Route::controller(\App\Http\Controllers\FeeController::class)->prefix('fee')->group(
        function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );
}
);
