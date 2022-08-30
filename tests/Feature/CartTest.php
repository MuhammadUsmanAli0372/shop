<?php

use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Cart;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('creates a cart for an unauthenticated user', function () {
    post(
        uri: route(name: 'api:v1:carts:store'),
    )->assertStatus(
        status: Http::CREATED,
    )->assertJson(fn (AssertableJson $json) =>
        $json
            ->where(key: 'type', expected: 'cart')
            ->where(key: 'attributes.status', expected: CartStatus::pending()->value)
            ->etc()
    );
});

it('returns a cart for a logged in  user', function () {
    $cart = Cart::factory()->create();

    auth()->loginUsingId($cart->user_id);

    get(
        uri: route('api:v1:carts:index')
    )->assertStatus(
        status: Http::OK,
    );
});

it('returns a not found status when a guest tries to retries their carts', function () {
    get(
        uri: route(name: 'api:v1:carts:index')
    )->assertStatus(
        status: Http::NO_CONTENT,
    );
});

it('can add a new product to a cart', function () {
    $cart = Cart::factory()->create();
    $variant = Variant::factory()->create();

    post(
        uri: route('api:v1:carts:products:store', $cart->uuid),
        data: [
            'quantity' => 1,
            'purchasable_id' => $variant->id,
            'purchasable_type' => 'variant'
        ],
    )->assertStatus(
        status: Http::CREATED,
    );
});

// do we have an active cart

// add products to a cart

// POST /cart/1234/products

// PATCH /carts/1234/products/abcd

// DELETE /carts/1234/products/abcd

// when logged in we can create a cart, and it is assign to our user.

// when not logged in we can create a cart, and the cart id is stored in the session variable.
