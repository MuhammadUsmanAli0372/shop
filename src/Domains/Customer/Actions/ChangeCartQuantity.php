<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;

class ChangeCartQuantity
{
    public static function handle(Cart $cart, CartItem $item, int $quantity = 0): void
    {

        // if quantity equals 0 then remove cart item
        if ($quantity === 0) {
            // remove item
            $item->delete();
        } else {
            //update cart item quantity
            $item->update([
                'quantity' => $quantity
            ]);
        }

        // $aggregate = CartAggregate::retrieve(
        //     uuid: $cart->uuid,
        // );

        // match (true) {
        //     $quantity === 0 => $aggregate->removeProduct(
        //                 purchasableID: $item->id,
        //                 cartID: $cart->id,
        //                 type:  $item::class,
        //             )->persist(),
        //     $quantity > $item->quantity => $aggregate->incrementQuantity(
        //                 cartID: $cart->id,
        //                 quantity:  $quantity,
        //                 cartItemID: $item->id,
        //             )->persist(),
        //     $quantity < $item->quantity => $aggregate->descreaseQuantity (
        //                 cartID: $cart->id,
        //                 quantity:  $quantity,
        //                 cartItemID: $item->id,
        //             )->persist()
        // };

        // switch ($quantity) {
        //     case ($quantity === 0):
        //         $aggregate->removeProduct(
        //             purchasableID: $item->id,
        //             cartID: $cart->id,
        //             type:  get_class($item),
        //         )->persist();
        //         break;
        //     case ($quantity > $item->quantity):
        //         $aggregate->incrementQuantity(
        //             cartID: $cart->id,
        //             quantity:  $quantity,
        //             cartItemID: $item->id,
        //         )->persist();
        //         break;
        //     case ($quantity < $item->quantity && $quantity > 0):
        //         $aggregate->descreaseQuantity (
        //             cartID: $cart->id,
        //             quantity:  $quantity,
        //             cartItemID: $item->id,
        //         )->persist();
        //         break;
        // }
    }
}

