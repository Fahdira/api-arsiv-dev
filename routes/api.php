<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ArsipController;
use App\Http\Controllers\Api\IjasahController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\KematianController;
use App\Http\Controllers\Api\KeuanganController;
use App\Http\Controllers\Api\KelahiranController;
use App\Http\Controllers\Api\PengajuanController;
use App\Http\Controllers\Api\PernikahanController;
use App\Http\Controllers\Api\JenisPengajuanController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::apiResource('jabatan', JabatanController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('jenis-pengajuan', JenisPengajuanController::class);
    Route::apiResource('pengajuan', PengajuanController::class);
    Route::apiResource('arsip', ArsipController::class);
    Route::apiResource('lahir', KelahiranController::class);
    Route::apiResource('mati', KematianController::class);
    Route::apiResource('ijasah', IjasahController::class);
    Route::apiResource('nikah', PernikahanController::class);
    Route::apiResource('uang', KeuanganController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
