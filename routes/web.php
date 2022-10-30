<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassicController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\FakeDataController;
use App\Http\Controllers\Auth\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function ($id = 1) {
    return view('welcome');
});

// social login -> socialite
//much better if javascript login
Route::get('google-login', [SocialController::class, 'loginWithGoogle'])->name('google.login');
Route::any('google/callback', [SocialController::class, 'callbackFromGoogle'])->name('google.callback');

Route::get('/generate-data', [FakeDataController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::name('user.')->group(function(){
        Route::get('/{user}', [UserController::class, 'getUser'])->name('get');
        Route::get('/match-history/{user}', [UserController::class, 'getMatchHistory'])->name('match-history');
        Route::get('/match-history-v2/{user}', [UserController::class, 'getMatchHistoryv2'])->name('match-history-2');
    });
});

Route::prefix('skeleton')->group(function(){
    Route::get('/classic', [ClassicController::class, 'index']);
});

Route::controller(DefaultController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('user-profile', 'userProfile');
    Route::get('match-history', 'matchHistory');
    Route::get('settings', 'settings');
    Route::get('classic', 'classic');
    Route::get('pvp', 'pvp');
});


