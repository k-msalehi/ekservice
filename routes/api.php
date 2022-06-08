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

Route::get('checkUser', function () {
    if (auth()->check())
        return response()->json(['login' => true, 'userDate' => auth()->user()], 200);
    else
        return response()->json(['login' =>  false], 200);
});
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('checkLoginCode', [AuthController::class, 'checkLoginCode'])->name('checkLoginCode');

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'store']);
    Route::post('{id}/update', [OrderController::class, 'update']);
    Route::post('{id}/delete', [OrderController::class, 'delete']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
