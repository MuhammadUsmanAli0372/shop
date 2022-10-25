<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Coupons\StoreRequest;
use App\Http\Resources\Api\V1\CartResource;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Cart $cart)
    {
        $coupon = Coupon::query()->where('code', $request->code)->firstOrFail();

        $cart->update([
            'coupon' => $coupon->code,
            'reduction' => $coupon->reduction,
        ]);

        // CartAggregate::retrieve(
        //     uuid: $cart->uuid
        // )->applyCoupon(
        //     cartID: $cart->id,
        //     code: $coupon->code
        // )->persist();

        $cart->refresh();

        return new Response(
            content: new CartResource(
                resource: $cart
            ),
            status: Http::ACCEPTED
        );
    }
}
