<?php

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Products\UpdateRequest;
use App\Http\Resources\Api\V1\CartResource;
use Domains\Customer\Actions\ChangeCartQuantity;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Cart $cart, CartItem $item): Response
    {
        ChangeCartQuantity::handle(
            cart: $cart,
            item:  $item,
            quantity: $request->get('quantity')
        );

        // // if quantity equals 0 then remove cart item
        // if ($request->get('quantity') === 0) {
        //     // remove item
        //     $item->delete();
        // } else {
        //     //update cart item quantity
        //     $item->update([
        //         'quantity' => $request->get('quantity')
        //     ]);
        // }

        $cart->refresh();

        return new Response(
            content: new CartResource(
                resource: $cart
            ),
            status: Http::ACCEPTED,
        );
    }
}
