<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CartResource;
use Domains\Customer\Actions\RemoveCouponFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, Cart $cart)
    {
        if ($cart->coupon === null) {
            // abort(
            //     code: Http::NOT_FOUND
            // );
            return new Response(
                content: ["msg" => "Coupon is not applied"],
                status: Http::ACCEPTED
            );
        }

        RemoveCouponFromCart::handle(
            cart: $cart
        );

        $cart->refresh();

        return new Response(
            content: new CartResource(
                resource: $cart
            ),
            status: Http::ACCEPTED
        );
    }
}
