<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Projectors;

use Domains\Fulfilment\Actions\CreateOrder;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Fulfilment\Factories\OrderFactory;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function onOrderWasCreated(OrderWasCreated $event): void
    {
        $object = OrderFactory::make(
            attributes: [
                'cart' => $event->cart,
                'billing' => $event->billing,
                'shipping' => $event->shipping,
                'user' => $event->user,
                'email' => $event->email
            ],
        );

        CreateOrder::handle(
            object: $object,
        );
    }
}