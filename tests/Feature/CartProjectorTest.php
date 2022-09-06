<?php

declare(strict_types=1);

use Domains\Customer\Events\IncrementCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Projectors\CartProjector;

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

it('can increase the quantity of the itemin the cart', function (IncrementCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(expected: 1);

    $this->projector->onIncreaseCartQuantity(
        event: $event
    );

    $cart->refresh();

    expect($cart->items->first()->quantity)->toEqual(expected: 2);

})->with('IncreaseCartQuantity');