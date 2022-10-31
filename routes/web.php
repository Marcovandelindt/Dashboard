<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/playstation/get-sessions', [App\Http\Controllers\Playstation\PlaystationGetSessionsController::class, 'index'])->name('playstation.sessions');

Route::get('/games', [App\Http\Controllers\GamesController::class, 'index'])->name('games.index');