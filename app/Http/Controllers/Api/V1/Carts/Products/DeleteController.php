<?php

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CartResource;
use Domains\Customer\Actions\RemoveProductFromCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $cart, CartItem $item)
    {
        $cart = Cart::query()->where('uuid', $cart)->first();

        RemoveProductFromCart::handle(
            cart: $cart,
            item: $item
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
