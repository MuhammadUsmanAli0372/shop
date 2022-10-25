<?php

declare(strict_types=1);

namespace Domains\Customer\ValueObjects;

class LoginValueObject
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}