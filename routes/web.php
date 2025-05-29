<?php

use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/purchase-order/{order}/preview', [PurchaseOrderController::class, 'preview'])
        ->name('purchase-order.preview');

    Route::get('/purchase-order/{order}/download', [PurchaseOrderController::class, 'download'])
        ->name('purchase-order.download');

    Route::get('/purchase-order/{order}/stream', [PurchaseOrderController::class, 'stream'])
        ->name('purchase-order.stream');
});
