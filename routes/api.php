<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(
    function () {
        Route::post('login', 'signin');
        Route::post('token', 'token');
        Route::post('user', 'signup');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', 'signout');
            Route::get('user', 'user');
            Route::put('user', 'changePassword');

            // Route::prefix('sessions')->group(function () {
            //     Route::get('', 'sessions');
            //     Route::get('{session}', 'showSession');
            //     Route::delete('{session}', 'revokeSession');
            // });
        });
    }
);
