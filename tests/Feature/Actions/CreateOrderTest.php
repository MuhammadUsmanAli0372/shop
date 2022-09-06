<?php

declare(strict_types=1);

use Domains\Customer\Actions\CreateOrder;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\OrderLine;
use Domains\Customer\ValueObjects\OrderValueObject;

it('can create an order', function (OrderValueObject $object) {  
    expect(Order::query()->count())->toEqual(expected: 0);

    CreateOrder::handle(
        object: $object
    );

    expect(Order::query()->count())->toEqual(expected: 1);
    expect(OrderLine::query()->count())->toEqual(expected: 1);

})->with('OrderValueObject');