<?php

declare(strict_types=1);

use Domains\Customer\Models\User;
use Domains\Customer\Models\Wishlist;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('can list all wishlists for a user', function () {
    auth()->login(User::factory()->create());

    Wishlist::factory()->create([
        'user_id' => auth()->id(),
    ]);

    expect(auth()->user()->wishlists()->count())->toBe(expected: 1);

    get(
        uri: route('api:v1:wishlists:index'),
    )->assertStatus(
        status: Http::OK
    )->assertJson(fn (AssertableJson $json) => 
            $json->count(key: 1),
    );

});

it('can get all public wishlists', function () {
    Wishlist::factory(12)->create([
        'public' => true,
    ]);

    Wishlist::factory(12)->create([
        'public' => false,
    ]);

    get(
        uri: route('api:v1:wishlists:index'),
    )->assertStatus(
        status: Http::OK
    )->assertJson(fn (AssertableJson $json) => 
            $json->count(key: 12),
    );
});

it('can create a new wishlist', function () {
    auth()->login(User::factory()->create());

    expect(Wishlist::query()->count())->toBe(expected: 0);

    post(
        uri: route('api:v1:wishlists:store'),
        data: [
            'name' => 'test',
            'products' => [
                1,2,3
            ],
        ]
    )->assertStatus(
        status: Http::CREATED
    );

    expect(Wishlist::query()->count())->toBe(expected: 1);
});

it('can show a specific wishlist', function () {
    $wishlist = Wishlist::factory()->create([
        'public' => true
    ]);

    get(
        uri: route('api:v1:wishlists:show', $wishlist->uuid)
    )->assertStatus(
        status: Http::OK
    )->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('attributes.name', $wishlist->name)
            ->where('type', 'wishlist')
            ->where('id', $wishlist->uuid)
            ->etc(),
    );
});

// it('can update a wishlist', function () {

// });

// it('can delete a wishlist', function () {

// });