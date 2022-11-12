<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PvpController;
use App\Http\Controllers\SkeletonController;
use App\Http\Controllers\Auth\AuthController;

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

Route::post('/auth', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/ip-address', function(){
        return url('/');
    });
    Route::get('/get-user', [AuthController::class, 'getUser']);
    Route::post('/set-match', [PvpController::class, 'setMatch']);
    Route::post('/save-match', [PvpController::class, 'saveMatch']);

    Route::post('/skeleton/versus-screen', [SkeletonController::class, 'versusScreen']);
});

Route::middleware('auth:sanctum')->get('/test-user', function (Request $request) {
    $oldUser = $request->user();;
    $user->tokens()->delete();
    return $oldUser;
});