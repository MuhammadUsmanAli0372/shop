<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Coupons\StoreRequest;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, $cart)
    {
        $coupon = Coupon::query()->where('code', $request->code)->firstOrFail();
        $cart = Cart::query()->where('uuid', $cart)->firstOrFail();

        // $cart->update([
        //     'coupon' => $coupon->code,
        //     'reduction' => $coupon->reduction,
        // ]);
        CartAggregate::retrieve(
            uuid: $cart->uuid
        )->applyCoupon(
            cartID: $cart->id,
            code: $coupon->code
        )->persist();

        return new Response(
            content: null,
            status: Http::ACCEPTED
        );
    }
}
