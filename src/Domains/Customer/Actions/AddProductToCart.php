<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\Cart;
use Domains\Customer\ValueObjects\CartItemValueObject;
use Illuminate\Database\Eloquent\Model;

class AddProductToCart
{
    public static function handle(CartItemValueObject $cartItem, Cart $cart): Model
    {
        return $cart->items()->updateOrCreate(
            ['cart_id' => $cart->id, 'purchasable_id' => $cartItem->purchasableId, 'purchasable_type' => $cartItem->purchasableType],
            ['quantity' => $cartItem->quantity]
        );
    }
}
