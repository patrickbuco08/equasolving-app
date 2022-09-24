<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\FakeDataController;

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

Route::get('/generate-data', [FakeDataController::class, 'index']);

Route::controller(DefaultController::class)->group(function () {
    Route::get('user-profile', 'userProfile');
    Route::get('match-history', 'matchHistory');
    Route::get('settings', 'settings');
    Route::get('classic', 'classic');
    Route::get('pvp', 'pvp');
});


