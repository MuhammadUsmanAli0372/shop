<?php

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncrementCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\assertDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

it('creates a cart for an unauthenticated user', function () {
    post(
        uri: route(name: 'api:v1:carts:store'),
    )->assertStatus(
        status: Http::CREATED,
    )->assertJson(
        fn (AssertableJson $json) => $json
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

it('returns a no  content  status when a guest tries to retries their carts', function () {
    get(
        uri: route(name: 'api:v1:carts:index')
    )->assertStatus(
        status: Http::NO_CONTENT,
    );
});

it('can add a new product to a cart', function () {
    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $cart = Cart::factory()->create();
    $variant = Variant::factory()->create();

    post(
        uri: route('api:v1:carts:products:store', $cart->uuid),
        data: [
            'quantity' => 1,
            'purchasable_id' => $variant->id,
            'purchasable_type' => 'variant',
        ],
    )->assertStatus(
        status: Http::CREATED,
    );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasAddedToCart::class);
    // dd(\Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent::query()->get());
});

it('can increase the quantity of an item in the cart', function () {
    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $item = CartItem::factory()->create(['quantity' => 3]);

    expect($item->quantity)->toEqual(expected: 3);

    patch(
        uri: route('api:v1:carts:products:update', [
            'cart' => $item->cart->uuid,
            'item' => $item->uuid
        ]),
        data: ['quantity' => 4],
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: IncrementCartQuantity::class);
});

it('can decrease the quantity of an item in the cart', function () {
    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $item = CartItem::factory()->create(['quantity' => 3]);

    expect($item->quantity)->toEqual(expected: 3);

    patch(
        uri: route('api:v1:carts:products:update', [
            'cart' => $item->cart->uuid,
            'item' => $item->uuid
        ]),
        data: ['quantity' => 1],
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: DecreaseCartQuantity::class);
    EloquentStoredEvent::query()->delete();
});

it('removes an item from the cart when quantity is zero', function () {
    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $item = CartItem::factory()->create(['quantity' => 3]);

    expect($item->quantity)->toEqual(expected: 3);

    patch(
        uri: route('api:v1:carts:products:update', [
            'cart' => $item->cart->uuid,
            'item' => $item->uuid
        ]),
        data: ['quantity' => 0],
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemoveFromCart::class);
    EloquentStoredEvent::query()->delete();
});

it('can remove an item from the cart', function () {
    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $item = CartItem::factory()->create(['quantity' => 3]);

    delete(
        uri: route('api:v1:carts:products:delete', [
            'cart' => $item->cart->uuid,
            'item' => $item
        ])
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemoveFromCart::class);
    EloquentStoredEvent::query()->delete();

    // dd($item);

    // assertDeleted($item);
});

// when not logged in we can create a cart, and the cart id is stored in the session variable.
