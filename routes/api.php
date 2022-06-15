<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
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

Route::get('pay', function () {
    // phpinfo();exit();
    return Payment::purchase(
        (new Invoice)->amount(1000),
        function ($driver, $transactionId) {
            // Store transactionId in database.
            // We need the transactionId to verify payment in the future.
        }
    )->pay()->render();
});


Route::get('checkUser', function () {
    if (auth('sanctum')->check())
        return response()->json(['login' => true, 'userDate' => auth('sanctum')->user()], 200);

    return response()->json(['login' =>  false], 200);
});

Route::get('login', function () {
    return app('res')->error('send Login data using POST method.');
});

Route::any('logout', function (Request $request) {
    try {
        if (auth('sanctum')->check()) {
            $user = auth('sanctum')->user();
            $user->tokens()->delete();
            auth('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return app('res')->success('logout success',['message' =>'first try']);
        } else {
            return app('res')->error('not logged in');
        }
    } catch (\Throwable $th) {
        return app('res')->success('logout success',['message' => $th->getMessage()]);
    }
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('checkLoginCode', [AuthController::class, 'checkLoginCode'])->name('checkLoginCode');

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'can:viewAdminPanel'])->group(function () {
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index']);
        Route::get('{order}', [AdminOrderController::class, 'show']);
        Route::post('/', [AdminOrderController::class, 'store']);
        Route::post('{order}/update', [AdminOrderController::class, 'update']);

        Route::post('{order}/note', [AdminOrderController::class, 'addNote']);
        Route::get('{order}/notes', [AdminOrderController::class, 'getNotes']);
        // Route::post('{id}/delete', [OrderController::class, 'delete']);
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index']);
        Route::get('{user}', [AdminUserController::class, 'show']);
        Route::post('/', [AdminUserController::class, 'store'])->middleware(['can:manageUsers']);
        Route::post('{user}/update', [AdminUserController::class, 'update'])->middleware(['can:manageUsers']);
    });
});

Route::middleware(['auth:sanctum'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->can('viewAny', Order::class);
    Route::get('{order}', [OrderController::class, 'show'])->middleware(['can:view,order']);
    Route::post('/', [OrderController::class, 'store'])->can('create', Order::class);
});



Route::middleware(['auth:sanctum'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->can('viewAny', Order::class);
    Route::get('{order}', [OrderController::class, 'show'])->middleware(['can:view,order']);
    Route::post('/', [OrderController::class, 'store'])->can('create', Order::class);
    // Route::post('{id}/update', [OrderController::class, 'update']);
    // Route::post('{id}/delete', [OrderController::class, 'delete']);

    // Route::get('pay');
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
