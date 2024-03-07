<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckerController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\MaterialMovementController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\TruckController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('drivers', [DriverController::class, 'index']);
    Route::get('trucks', [TruckController::class, 'index']);
    Route::get('stations', [StationController::class, 'index']);
    Route::get('checkers', [CheckerController::class, 'index']);
    Route::get('material-movements', [MaterialMovementController::class, 'index']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('driver', [DriverController::class, 'store']);
    Route::get('driver/{id}', [DriverController::class, 'show']);
    Route::post('driver/{id}', [DriverController::class, 'update']);
    Route::post('driver/active/{id}', [DriverController::class, 'updateActiveStatus']);
    Route::delete('driver/{id}', [DriverController::class, 'destroy']);

    Route::post('truck', [TruckController::class, 'store']);
    Route::get('truck/{id}', [TruckController::class, 'show']);
    Route::post('truck/{id}', [TruckController::class, 'update']);
    Route::post('truck/active/{id}', [TruckController::class, 'updateActiveStatus']);
    Route::delete('truck/{id}', [TruckController::class, 'destroy']);

    Route::post('station', [StationController::class, 'store']);
    Route::get('station/{id}', [StationController::class, 'show']);
    Route::post('station/{id}', [StationController::class, 'update']);
    Route::post('station/active/{id}', [StationController::class, 'updateActiveStatus']);
    Route::delete('station/{id}', [StationController::class, 'destroy']);

    Route::post('checker', [CheckerController::class, 'store']);
    Route::get('checker/{id}', [CheckerController::class, 'show']);
    Route::post('checker/{id}', [CheckerController::class, 'update']);
    Route::post('checker/active/{id}', [CheckerController::class, 'updateActiveStatus']);
    Route::delete('checker/{id}', [CheckerController::class, 'destroy']);

    Route::post('material-movement', [MaterialMovementController::class, 'store']);
    Route::get('material-movement/{id}', [MaterialMovementController::class, 'show']);
    Route::post('material-movement/{id}', [MaterialMovementController::class, 'update']);
    Route::delete('material-movement/{id}', [MaterialMovementController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:checker'])->group(function () {
    Route::post('checker/store/material-movement', [MaterialMovementController::class, 'store']);
});
