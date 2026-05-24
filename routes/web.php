<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasSiagaController;
use App\Http\Controllers\TasItemController;
use App\Http\Controllers\SupplyController;

// ─── Halaman Utama ───────────────────────────────────────
Route::get('/',         fn() => view('netral.index'))->name('netral');
Route::get('/sebelum',  [TasSiagaController::class, 'index'])->name('sebelum');
Route::get('/saat',     fn() => view('saat.index'))->name('saat');
Route::get('/sesudah',  [SupplyController::class, 'index'])->name('sesudah');

// ─── PWA & Hybrid Sync API ───────────────────────────────
// Ditambahkan di sini agar Alpine.js bisa fetch data sinkronisasi offline-to-online
Route::get('/api/tas-siaga', [TasSiagaController::class, 'getData']);
Route::post('/api/tas-siaga/sync', [TasSiagaController::class, 'syncData']);

// ─── Tas Siaga API ───────────────────────────────────────
Route::prefix('api/tas')->name('tas.')->group(function () {
    Route::post('/',                     [TasSiagaController::class, 'store'])->name('store');
    Route::post('/{tas}/aktif',         [TasSiagaController::class, 'setActive'])->name('aktif');
    Route::delete('/{tas}',             [TasSiagaController::class, 'destroy'])->name('destroy');
    Route::get('/rekomendasi/{kategori}',[TasSiagaController::class, 'rekomendasi'])->name('rekomendasi');
    Route::get('/{tas}/items',          [TasSiagaController::class, 'getItems'])->name('items');
});

// ─── Tas Item API ─────────────────────────────────────────
Route::prefix('api/item')->name('item.')->group(function () {
    Route::post('/',                    [TasItemController::class, 'store'])->name('store');
    Route::patch('/{tasItem}/zona',     [TasItemController::class, 'updateZona'])->name('zona');
    Route::delete('/{tasItem}',         [TasItemController::class, 'destroy'])->name('destroy');
});