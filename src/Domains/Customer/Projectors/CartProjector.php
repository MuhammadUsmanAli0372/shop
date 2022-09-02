<?php

declare(strict_types=1);

namespace Domains\Customer\Projector;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncrementCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
    public function onProductWasAddedToCart(ProductWasAddedToCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID
        );

        $cart->items()->create([
            'purchasable_id' => $event->purchasableID,
            'purchasable_type' => $event->type,
        ]);
    }

    public function onProductWasRemoveFromCart(ProductWasRemoveFromCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID
        );

        $cart->items()
                ->where('purchasable_id', $event->purchasableID)
                ->where('purchasable_type', $event->type)
                ->delete();
    }

    public function onIncreaseCartQuantity(IncrementCartQuantity $event): void
    {
        $item = CartItem::query()->where(
            column: 'cart_id',
            value: $event->cartID
        )->where(
            column: 'id',
            value: $event->cartItemId
        )->first();

        $item->update([
            'quantity' => ($item->quantity + $event->qunatity),
        ]);
    }

    public function onDecreaseCartQuantity(DecreaseCartQuantity $event): void
    {
        $item = CartItem::query()->where(
            column: 'cart_id',
            value: $event->cartID
        )->where(
            column: 'id',
            value: $event->cartItemId
        )->first();

        if ($event->quantity >= $item->qunatity) {
            CartAggregate::retrieve(
                uuid: Str::uuid()->toString(),
            )->removeProduct(
                purchasableID: $item->purchasable->id,
                cartID: $item->cart_id,
                type: get_class($item->purchasable)
            );

            return;
        }

        $item->update([
            'quantity' => ($item->quantity - $event->qunatity),
        ]);
    }
}
