<?php

use Domains\Customer\Factories\CartFactory;
use Domains\Customer\ValueObjects\CartValueObject;

it('can create a cart value object', function () {
    expect(
        CartFactory::make(
            attributes: [
                'status' => 'test',
                'user_id' => 1,
            ],
        ),
    )->toBeInstanceOf(class: CartValueObject::class)
        ->status
        ->toBe(expected: 'test');
});
