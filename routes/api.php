<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\User\
{
    AuthController,
    UserController
};
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', [AuthController::class, 'Login']);


Route::post('/register', [AuthController::class, 'Register']);

Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});


Route::get('/user', [UserController::class, 'User'])->middleware('auth:api');


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.request');


Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');




