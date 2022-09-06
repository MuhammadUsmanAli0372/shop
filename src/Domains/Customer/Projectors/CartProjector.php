<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Actions\CouponWasApplied;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncrementCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
    public function onProductWasAddedToCart(ProductWasAddedToCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID
        );

        $item = $cart->items()->create([
            'quantity' => 1,
            'purchasable_id' => $event->purchasableID,
            'purchasable_type' => $event->type,
        ]);

        // Update a cart
        $cart->update([
            'total' => $item->purchasable->retail,
        ]);
    }

    public function onProductWasRemoveFromCart(ProductWasRemoveFromCart $event): void
    {
        $cart = Cart::query()->with(['items'])->find(
            id: $event->cartID
        );

        $items = $cart->items;

        // $item = $items->filter(fn(Model $item) => 
        //                 $item->id === $event->purchasableID
        //             )->first();

        $item = $items->first();

        if ($items->count() === 1) {
            $cart->update([
                'total' => 0
            ]);
        } else {
            $cart->update([
                'total' => ($cart->total - $item?->purchasable->retail ?? 0)
            ]);
        }

        $cart->items()
            ->where(['purchasable_id' => $item?->purchasable->id, 'purchasable_type' => strtolower(class_basename($item?->purchasable))])
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

        $item = CartItem::query()->find($event->cartItemId);

        $item->update([
            'quantity' => ($item->quantity + $event->quantity),
        ]);
    }

    public function onDecreaseCartQuantity(DecreaseCartQuantity $event): void
    {
        $cart = Cart::query()->with(['items'])->find($event->cartID);

        $item = CartItem::query()->with(['cart'])->where(
            column: 'cart_id',
            operator: '=',
            value: $event->cartID
        )->where(
            column: 'id',
            operator: '=',
            value: $event->cartItemId
        )->first();

        if ($event->quantity >= $item->quantity) {
            CartAggregate::retrieve(
                uuid: $item->cart->uuid,
            )->removeProduct(
                purchasableID: $item->purchasable->id,
                cartID: $item->cart->id,
                type: get_class($item->purchasable)
            )->persist();

            return;
        }

        $item->update([
            'quantity' => $event->quantity,
        ]);
    }

    public function onCouponWasApplied(CouponWasApplied $event): void
    {
        $coupon = Coupon::query()->where('code', $event->code)->first();

        Cart::query()->where('id', '=',  $event->cartID)->update([
            'coupon' => $coupon->code,
            'reduction' => $coupon->reduction
        ]);
    }
}
