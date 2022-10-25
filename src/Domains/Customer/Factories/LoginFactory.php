<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\LoginValueObject;

class LoginFactory
{
    /**
     * @param  array  $attributes
     * @return LoginValueObject
     */
    public static function make(array $attributes): LoginValueObject
    {
        return new LoginValueObject(
            email: $attributes['email'],
            password: $attributes['password'],
        );
    }
}