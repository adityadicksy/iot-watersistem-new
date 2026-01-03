<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Jalur bawaan (biarkan saja)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- JALUR PROJECT KITA ---

// 1. Jalur untuk SIM900 MENGIRIM data (POST)
Route::post('/simpan-sensor', [SensorController::class, 'store']);

// 2. Jalur untuk Website MENGAMBIL data terbaru (GET)
Route::get('/sensor-terbaru', [SensorController::class, 'getLatest']);
