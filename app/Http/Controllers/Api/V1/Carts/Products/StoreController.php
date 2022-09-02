<?php

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\ProductRequest;
use Domains\Customer\Actions\AddProductToCart;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Factories\CartItemFactory;
use Domains\Customer\Models\Cart;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(ProductRequest $request, Cart $cart): Response
    {
        CartAggregate::retrieve(
            uuid: $cart->uuid,
        )->addProduct(
            purchasableID: $request->get('purchasable_id'),
            type: $request->get('purchasable_type'),
            cartID: $cart->id
        )->persist();

        // $cartItem = AddProductToCart::handle(
        //     cartItem: CartItemFactory::make(
        //         attributes: $request->validated(),
        //     ),
        //     cart: $cart
        // );

        return new Response(
            content: null,
            status: Http::CREATED
        );
    }
}
