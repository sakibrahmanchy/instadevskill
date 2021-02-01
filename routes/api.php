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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/email/verify/{id}', [\App\Http\Controllers\VerificationController::class, 'verify'])
    ->name('verification.verify');
Route::post('/forgot-password', [\App\Http\Controllers\PasswordController::class, 'forgotPassword'])
    ->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', function ($token) {
    dd($token);
})->middleware('guest')->name('password.reset');

Route::get('/email/resend', [\App\Http\Controllers\VerificationController::class, 'resend'])
    ->name('verification.resend')->middleware('auth:api');

Route::middleware(['auth:api', 'verified'])->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('follow', [\App\Http\Controllers\UserController::class, 'follow']);
    Route::post('unfollow', [\App\Http\Controllers\UserController::class, 'unfollow']);
    Route::get('followers', [\App\Http\Controllers\UserController::class, 'followers']);
});

