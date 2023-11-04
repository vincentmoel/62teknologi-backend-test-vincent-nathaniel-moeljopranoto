<?php

use App\Http\Controllers\BusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('businesses/search', [BusinessController::class, 'index']);
Route::apiResource('businesses', BusinessController::class);
Route::patch('businesses/{businessId}/restore', [BusinessController::class, 'restore']);
