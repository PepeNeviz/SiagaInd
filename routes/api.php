<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasSiagaController;

Route::post('/tas',                    [TasSiagaController::class, 'store']);
Route::post('/tas/{tas}/aktif',        [TasSiagaController::class, 'setActive']);
Route::patch('/tas/{tas}',             [TasSiagaController::class, 'update']);
Route::delete('/tas/{tas}',            [TasSiagaController::class, 'destroy']);
Route::get('/tas/{tas}/items',         [TasSiagaController::class, 'getItems']);
Route::get('/tas/rekomendasi/{kategori}', [TasSiagaController::class, 'rekomendasi']);