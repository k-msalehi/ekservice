<?php

use App\Http\Controllers\AuthController;
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

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('checkLoginCode/{tel}', [AuthController::class, 'checkLoginCode'])->name('checkLoginCode');
// $url = URL::signedRoute('login', ['tel' => 429]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
