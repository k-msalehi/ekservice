<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::post('order/create', [OrderController::class, 'create']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('checkLoginCode', [AuthController::class, 'checkLoginCode'])->name('checkLoginCode');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
