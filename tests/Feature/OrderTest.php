<?php

use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Fulfilment\Models\Order;
use Domains\Customer\Models\User;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;

it('can create an order from a cart for an unauthenticated user', function (CartItem $cartItem ) {
    Order::query()->delete();

    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
            'cart' => $cartItem->cart->uuid,
            'email' => 'usmanalimuhammad513@gmail.com',
            'shipping' => $location->id,
            'billing' => $location->id
        ]
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: OrderWasCreated::class);
    EloquentStoredEvent::query()->delete();
    
})->with('3CartItems');

it('can create an order from a cart for an authenticated user', function (CartItem $cartItem ) {
    Order::query()->delete();

    auth()->login(User::factory()->create());

    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
            'cart' => $cartItem->cart->uuid,
            'shipping' => $location->id,
            'billing' => $location->id
        ]
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: OrderWasCreated::class);
    EloquentStoredEvent::query()->delete();
    
})->with('3CartItems');