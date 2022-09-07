<?php

declare(strict_types=1);

namespace Domains\Customer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

abstract class QuantityEvent extends ShouldBeStored
{
    public function __construct(
        public $cartID,
        public int $cartItemId,
        public int $quantity,
    ) {
    }
}
