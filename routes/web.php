<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Saat buka halaman utama (http://127.0.0.1:8000), panggil fungsi index
Route::get('/', [SensorController::class, 'index']);
