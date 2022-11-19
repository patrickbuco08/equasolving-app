<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ClassicController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\FakeDataController;
use App\Http\Controllers\SkeletonController;
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

Route::get('/ip-address', function () {
    echo url('/');
});

// social login -> socialite
//much better if javascript login
Route::get('google-login', [SocialController::class, 'loginWithGoogle'])->name('google.login');
Route::any('google/callback', [SocialController::class, 'callbackFromGoogle'])->name('google.callback');

// logout
Route::post('logout', [LogoutController::class, 'store'])->name('logout');
Route::post('ajax-logout', [LogoutController::class, 'ajaxLogout']);

Route::get('/generate-data', [FakeDataController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::name('user.')->group(function(){
        Route::get('/manual-login/{user}', [UserController::class, 'manualLogin'])->name('manual-login');
        Route::get('/check-auth', [UserController::class, 'checkIfAuthenticated'])->name('check');
        Route::get('/{user}', [UserController::class, 'getUser'])->name('get');
        Route::get('/match-history/{user}', [UserController::class, 'getMatchHistory'])->name('match-history');
        Route::get('/match-history-v2/{user}', [UserController::class, 'getMatchHistoryv2'])->name('match-history-2');
        Route::post('create-using-nickname', [UserController::class, 'createUsingNickName'])->name('create-using-nickname');
    });
});

// skeleton
Route::prefix('skeleton')->group(function () {
    Route::name('skeleton.')->group(function(){
        Route::get('/welcome', [SkeletonController::class, 'welcome']);
        Route::get('/loader/{text}', [SkeletonController::class, 'loader']);
        Route::get('/nickname', [SkeletonController::class, 'nickname'])->name('get-nickname');
        Route::get('/classic', [SkeletonController::class, 'classic']);
        Route::get('/classic-summary/{level}/{trophies}', [SkeletonController::class, 'classicSummary']);
        Route::get('/home', [SkeletonController::class, 'home'])->name('get-home');
        Route::get('/match-history', [SkeletonController::class, 'matchHistory'])->name('get-matchHistory');
        Route::get('/find-match', [SkeletonController::class, 'findMatch'])->name('find-match');
        Route::get('/shop', [SkeletonController::class, 'shop']);
        Route::post('/versus-screen', [SkeletonController::class, 'versusScreen']);
        Route::post('/win-lose-announcement', [SkeletonController::class, 'winLoseAnnouncement']);
    });
});

Route::controller(DefaultController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('user-profile', 'userProfile');
    Route::get('match-history', 'matchHistory');
    Route::get('settings', 'settings');
    Route::get('classic', 'classic');
    Route::get('pvp', 'pvp');
    Route::get('shop', 'shop');
    Route::get('find-match', 'findMatch');
    Route::get('versus-screen', 'versusScreen');
});

