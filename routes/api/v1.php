<?php

use App\Http\Controllers\Api\V1\Carts\IndexController;
use App\Http\Controllers\Api\V1\Carts\Products\DeleteController;
use App\Http\Controllers\Api\V1\Carts\Products\StoreController as ProductsStoreController;
use App\Http\Controllers\Api\V1\Carts\Products\UpdateController;
use App\Http\Controllers\Api\V1\Carts\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('auth:me');

/**
 * Product Routes
 */
Route::prefix('products')->as('products:')->group(function () {
    /**
     * Show all Products
     */
    Route::get(
        uri: '/',
        action: App\Http\Controllers\Api\V1\Products\IndexController::class,
    )->name('index');

    Route::get(
        uri: '{key}',
        action: App\Http\Controllers\Api\V1\Products\ShowController::class,
    )->name('show');
});

/**
 * Cart Routes
 */
Route::prefix('carts')->as('carts:')->group(function () {
    /**
     * Get the users cart
     */
    Route::get('/', IndexController::class)->name('index');

    /**
     * Create a new Cart
     */
    Route::post('/', StoreController::class)->name('store');

    /**
     * Add a product to cart
     */
    Route::post('{cart:uuid}/products', ProductsStoreController::class)->name('products:store');

    /**
     * Update Quantity
     */
    Route::patch('{cart:uuid}/products/{item:uuid}', UpdateController::class)->name('products:update');

    /**
     * Delete Product
     */
    Route::delete('{cart::uuid}/products/{item:uuid}', DeleteController::class)->name('products:delete');
});
