<?php

use App\Http\Controllers\GuiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', GuiController::class);
Route::post('login', LoginController::class);
Route::post('send', SendController::class);
