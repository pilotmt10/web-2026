<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::group([], function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
});
