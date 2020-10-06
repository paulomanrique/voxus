<?php

use App\Http\Controllers\UserLocationController;
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

Route::get('/user_location/{id}', [UserLocationController::class, 'show'])->name('user_location.show');
Route::post('/user_location', [UserLocationController::class, 'store'])->name('user_location.store');
