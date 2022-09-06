<?php

declare(strict_types=1);

use Domains\Customer\Actions\CouponWasApplied;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncrementCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Projectors\CartProjector;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

beforeEach(fn() => $this->projector = new CartProjector());

it('can add an product to cart', function (ProductWasAddedToCart $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->with(['items.purchasable'])->find($event->cartID);

    expect(
        $cart->items->count()
    )->toEqual(expected: 0);

    expect(
        $cart->total
    )->toEqual(expected: 0);

    $this->projector->onProductWasAddedToCart(
        event: $event
    );

    $cart->refresh();

    expect(
        $cart->items->count()
    )->toEqual(expected: 1);

    expect(
        $cart->total
    )->toEqual($cart->items->first()->purchasable->retail);

})->with('AddedToCart');

it('can remove a product from cart', function (ProductWasRemoveFromCart $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->with(['items.purchasable'])->find($event->cartID);

    expect(
        $cart->items->count()
    )->toEqual(expected: 1);

    $this->projector->onProductWasRemoveFromCart(
        event: $event
    );

    $cart->refresh(); 

    expect(
        $cart->items->count()
    )->toEqual(expected: 0);

    expect(
        $cart->total
    )->toEqual(expected: 0);

})->with('RemovedFromCart');

it('can increase the quantity of item in the cart', function (IncrementCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(expected: 1);

    $this->projector->onIncreaseCartQuantity(
        event: $event
    );

    $cart->refresh();

    expect($cart->items->first()->quantity)->toEqual(expected: 2);

})->with('IncreaseCartQuantity');

it('can descrease the quantity of item in the cart', function (DecreaseCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(expected: 3);

    $this->projector->onDecreaseCartQuantity(
        event: $event
    );

    $cart->refresh();

    expect($cart->items->first()->quantity)->toEqual(expected: 2);

})->with('DecreaseCartQuantity');

it('removes the item from the cart when you are trying to remove more than or equal to the quantity', function (DecreaseCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(expected: 1);

    $this->projector->onDecreaseCartQuantity(
        event: $event
    );

    $cart->refresh();

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemoveFromCart::class);
    EloquentStoredEvent::query()->delete();

})->with('RemoveCartQuantity');

it('can apply coupon in the cart', function (CouponWasApplied $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    expect(
        Cart::query()->find($event->cartID)->code
    )->toBeNull();

    $this->projector->onCouponWasApplied(
        event: $event
    );

    expect(
        Cart::query()->find($event->cartID)->coupon
    )->toBeString();

    expect(
        Cart::query()->find($event->cartID)->coupon
    )->toEqual(expected: $event->code);

})->with('ApplyCouponToCart');