<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Customer\Actions\CouponWasApplied;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncrementCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemoveFromCart;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregate extends AggregateRoot
{
    public function addProduct(int $purchasableID, int $cartID, string $type): self
    {
        $this->recordThat(
            domainEvent: new ProductWasAddedToCart(
                purchasableID: $purchasableID,
                cartID: $cartID,
                type: $type
            ),
        );

        return $this;
    }

    public function removeProduct(int $purchasableID, int $cartID, string $type): self
    {
        $this->recordThat(
            domainEvent: new ProductWasRemoveFromCart(
                purchasableID: $purchasableID,
                cartID: $cartID,
                type: $type,
            )
        );

        return $this;
    }

    public function incrementQuantity(int $cartID, int $cartItemID, int $quantity): self
    {
        $this->recordThat(
            domainEvent: new IncrementCartQuantity(
                cartID: $cartID,
                cartItemId: $cartItemID,
                qunatity: $quantity
            ),
        );

        return $this;
    }

    public function descreaseQuantity(int $cartID, int $cartItemID, int $quantity): self
    {
        $this->recordThat(
            domainEvent: new DecreaseCartQuantity(
                cartID: $cartID,
                cartItemId: $cartItemID,
                qunatity: $quantity
            ),
        );

        return $this;
    }

    public function applyCoupon(int $cartID, string $code): self
    {
        $this->recordThat(
            domainEvent: new CouponWasApplied(
                cartID: $cartID,
                code: $code
            ),
        );
        
        return $this;
    }
}
