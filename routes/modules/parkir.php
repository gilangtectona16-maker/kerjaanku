<?php

use App\Http\Controllers\ParkirController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('parkir', [ParkirController::class, 'index'])->name('parkir.index');

    Route::get('parkir/masuk', [ParkirController::class, 'masuk'])->name('parkir.masuk');
    Route::post('parkir/masuk', [ParkirController::class, 'storeMasuk'])->name('parkir.masuk.store');

    Route::get('parkir/keluar', [ParkirController::class, 'keluar'])->name('parkir.keluar');
    Route::post('parkir/keluar', [ParkirController::class, 'storeKeluar'])->name('parkir.keluar.store');
});