<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DefinitionController;
use App\Http\Controllers\WordController;

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

Route::apiResource('words', WordController::class)
    ->middleware('auth:sanctum')->only(['index']);

Route::group(['prefix' => 'definitions', 'controller' => DefinitionController::class], function () {
    Route::get('', 'index');
    Route::post('', 'store')->middleware('auth:sanctum');
});
