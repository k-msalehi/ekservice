<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
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
        return response()->json(['login' => true, 'sanctum' => false, 'userDate' => auth()->user()], 200);

    if (auth('sanctum')->check())
        return response()->json(['login' => true, 'sanctum' => true, 'userDate' => auth()->user()], 200);

    return response()->json(['login' =>  false], 200);
});

Route::get('login', function () {
    return app('res')->error('send Login data using POST request.');
});
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('checkLoginCode', [AuthController::class, 'checkLoginCode'])->name('checkLoginCode');

Route::middleware(['auth:sanctum'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->can('viewAny', Order::class);
    Route::get('{order}', [OrderController::class, 'show'])->middleware(['can:view,order']);
    Route::post('/', [OrderController::class, 'store'])->can('create', Order::class);
    // Route::post('{id}/update', [OrderController::class, 'update']);
    // Route::post('{id}/delete', [OrderController::class, 'delete']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
