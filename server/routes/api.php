<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::name('user.')
    ->prefix('user')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
    });

Route::post('/register', [AuthController::class, 'register']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
