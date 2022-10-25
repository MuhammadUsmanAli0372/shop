<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\UserController;
use App\Http\Controllers\Api\V1\Carts\Coupons\DeleteController as CouponsDeleteController;
use App\Http\Controllers\Api\V1\Carts\Coupons\StoreController as CouponsStoreController;
use App\Http\Controllers\Api\V1\Carts\IndexController;
use App\Http\Controllers\Api\V1\Carts\Products\DeleteController;
use App\Http\Controllers\Api\V1\Carts\Products\StoreController as ProductsStoreController;
use App\Http\Controllers\Api\V1\Carts\Products\UpdateController;
use App\Http\Controllers\Api\V1\Carts\StoreController;
use App\Http\Controllers\Api\V1\Categories\DeleteController as CategoriesDeleteController;
use App\Http\Controllers\Api\V1\Categories\IndexController as CategoriesIndexController;
use App\Http\Controllers\Api\V1\Categories\ShowController as CategoriesShowController;
use App\Http\Controllers\Api\V1\Categories\StoreController as CategoriesStoreController;
use App\Http\Controllers\Api\V1\Categories\UpdateController as CategoriesUpdateController;
use App\Http\Controllers\Api\V1\Orders\StoreController as OrdersStoreController;
use App\Http\Controllers\Api\V1\Orders\StripeWebhookController;
use App\Http\Controllers\Api\V1\Products\DeleteController as ProductsDeleteController;
use App\Http\Controllers\Api\V1\Products\StoreController as V1ProductsStoreController;
use App\Http\Controllers\Api\V1\Products\UpdateController as ProductsUpdateController;
use App\Http\Controllers\Api\V1\Wishlists\IndexController as WishlistsIndexController;
use App\Http\Controllers\Api\V1\Wishlists\ShowController;
use App\Http\Controllers\Api\V1\Wishlists\StoreController as WishlistsStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// })->name('auth:me');

Route::prefix('user')->as('user:')->middleware('auth:api')->group(function() {
    /**
     * Get User
     */
    Route::get(
        uri: '/me',
        action: UserController::class
    )->name('me');
});

/**
 * Auth Routes
 */
Route::prefix('auth')->as('auth:')->group(function () {
    /**
     * Login User
     */
    Route::post(
        uri: '/login',
        action: LoginController::class,
    )->name('login');

    /**
     * Register User
     */
    Route::post(
        uri: '/register',
        action: RegisterController::class
    )->name('register');
});

/**
 * Category Routes
 */
Route::prefix('categories')->as('categories:')->group(function () {
    /**
     * Show all Categories
     */
    Route::get(
        uri: '/',
        action: CategoriesIndexController::class,
    )->name('index');

    /**
     * Get Single Category by key
     */
    Route::get(
        uri: '/{categories:key}',
        action: CategoriesShowController::class,
    )->name('show');

    /**
     * Create Category
     */
    Route::post(
        uri: '/create',
        action: CategoriesStoreController::class
    )->name('create');

    /**
     * Update Category
     */
    Route::post(
        uri: '/update/{categories:key}',
        action: CategoriesUpdateController::class
    )->name('update');

    /**
     * Delete Category
     */
    Route::delete(
        uri: '/delete/{categories:key}',
        action: CategoriesDeleteController::class
    )->name('delete');
});

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

    /**
     * Get Single Product by key
     */
    Route::get(
        uri: '{key}',
        action: App\Http\Controllers\Api\V1\Products\ShowController::class,
    )->name('show');

    /**
     * Create Product
     */
    Route::post(
        uri: '/create',
        action: V1ProductsStoreController::class
    )->name('create');

    /**
     * Update Product
     */
    Route::post(
        uri: '/update/{key}',
        action: ProductsUpdateController::class
    )->name('update');

    /**
     * Delete Product
     */
    Route::delete(
        uri: '/delete/{products:key}',
        action: ProductsDeleteController::class
    )->name('delete');

});

/**
 * Cart Routes
 */
Route::prefix('carts')->as('carts:')->group(function () {
    /**
     * Get the user cart
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
    Route::delete('{cart:uuid}/products/{item:uuid}', DeleteController::class)->name('products:delete');

    /**
     * Add a coupon to our cart
     */
    Route::post('{cart:uuid}/coupons', CouponsStoreController::class)->name('coupons:store');

    /**
     * Remove a coupon to our cart
     */
    Route::delete('{cart:uuid}/coupons', CouponsDeleteController::class)->name('coupons:delete');
});

/**
 * Orders Routes
 */
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
