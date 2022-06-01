<?php

use App\Http\Controllers\AuthController;
use App\Services\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/', function () {
    return view('welcome');
});

Route::post('ttttt', [AuthController::class, 'login'])->name('ttt3');
