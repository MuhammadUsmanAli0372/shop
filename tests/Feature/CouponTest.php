<?php

declare(strict_types=1);

use Domains\Customer\Actions\CouponWasApplied;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\delete;
use function Pest\Laravel\post;


it('can remove the coupon from the cart', function (Cart $cartWithCoupon) {
    expect($cartWithCoupon->refresh())->coupon->toBeString();

    $coupon = Coupon::query()->where('code', $cartWithCoupon->coupon)->firstOrFail();

    delete(
        uri: route('api:v1:carts:coupons:delete', [
            'cart' => $cartWithCoupon->uuid,
            'uuid' => $coupon->uuid
        ]),
    )->assertStatus(status: Http::ACCEPTED);

    expect($cartWithCoupon->refresh())->couponn->toBeNull();

})->with('cartWithCoupon');

it('can apply a coupon to the cart', function (Cart $cart, Coupon $coupon) {
    EloquentStoredEvent::query()->delete();
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    expect($cart)
            ->reduction
            ->toEqual(expected: 0);

    post(
        uri: route('api:v1:carts:coupons:store', $cart->uuid),
        data: ['code' => $coupon->code]
    )->assertStatus(status: Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: CouponWasApplied::class);
    EloquentStoredEvent::query()->delete();

})->with('cart', 'coupon');