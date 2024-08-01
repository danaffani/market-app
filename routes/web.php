<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', [ItemController::class, 'index']);

Route::resource('items', ItemController::class);
Route::get('/preview-sale', [ItemController::class, 'previewSale'])->name('preview_sale');
Route::get('/final-sale', [ItemController::class, 'finalSale'])->name('final_sale');
Route::post('/sales/complete', [ItemController::class, 'completeSale'])->name('sales.complete');