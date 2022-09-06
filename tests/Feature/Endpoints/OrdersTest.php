<?php

declare(strict_types=1);

use Domains\Customer\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;

it('can create an order from a cart using the API when not logged in', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $item = CartItem::factory()->create();
    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
            'cart' => $item->cart->uuid,
            'email' => 'usmanalimuhammad513@gmail.com',
            'shipping' => $location->id,
            'billing' => $location->id,
        ]
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: OrderWasCreated::class);
});

it('can create an order from a cart using the API when logged in', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    auth()->login(User::factory()->create());

    $item = CartItem::factory()->create();
    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
            'cart' => $item->cart->uuid,
            'shipping' => $location->id,
            'billing' => $location->id,
        ]
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: OrderWasCreated::class);
});