<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\RegisterValueObject;

class RegisterFactory
{
    /**
     * @param  array  $attributes
     * @return RegisterValueObject
     */
    public static function make(array $attributes): RegisterValueObject
    {
        return new RegisterValueObject(
            first_name: $attributes['first_name'],
            last_name: $attributes['last_name'],
            email: $attributes['email'],
            password: $attributes['password'],
        );
    }
}