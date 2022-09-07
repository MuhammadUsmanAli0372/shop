<?php

use App\Http\Controllers\Api\V1\Carts\Coupons\DeleteController as CouponsDeleteController;
use App\Http\Controllers\Api\V1\Carts\Coupons\StoreController as CouponsStoreController;
use App\Http\Controllers\Api\V1\Carts\IndexController;
use App\Http\Controllers\Api\V1\Carts\Products\DeleteController;
use App\Http\Controllers\Api\V1\Carts\Products\StoreController as ProductsStoreController;
use App\Http\Controllers\Api\V1\Carts\Products\UpdateController;
use App\Http\Controllers\Api\V1\Carts\StoreController;
use App\Http\Controllers\Api\V1\Orders\StoreController as OrdersStoreController;
use App\Http\Controllers\Api\V1\Orders\StripeWebhookController;
use App\Http\Controllers\Api\V1\Wishlists\IndexController as WishlistsIndexController;
use App\Http\Controllers\Api\V1\Wishlists\ShowController;
use App\Http\Controllers\Api\V1\Wishlists\StoreController as WishlistsStoreController;
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

    /**
     * Add a coupon to our cart
     */
    Route::post('{cart::uuid}/coupons', CouponsStoreController::class)->name('coupons:store');

    /**
     * Remove a coupon to our cart
     */
    Route::delete('{cart::uuid}/coupons/{uuid}', CouponsDeleteController::class)->name('coupons:delete');
});

Route::prefix('orders')->as('orders:')->group(function () {
    /**
     * Turn a Cart into an Order
     */
    Route::post('/', OrdersStoreController::class)->name('store');
});

/**
 * Wishlist Routes
 */
Route::prefix('wishlists')->as('wishlists:')->group(function () {
    /**
     * Get All Wishlists
     */
    Route::get('/', WishlistsIndexController::class)->name('index');

    /**
     * Create a new Wishlist
     */
    Route::post('/', WishlistsStoreController::class)->name('store');

    /**
     * Show a wishlist
     */
    Route::get('/{wishlist:uuid}', ShowController::class)->name('show');
});

/**
 * Stripe Webhooks
 */
Route::middleware(['stripe-webhooks'])->group(function () {
    Route::post('stripe/webhook', StripeWebhookController::class)->name('stripe-webhooks');
});
