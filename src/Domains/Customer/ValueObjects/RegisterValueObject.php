<?php

declare(strict_types=1);

namespace Domains\Customer\ValueObjects;

use Illuminate\Support\Facades\Hash;

class RegisterValueObject
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password
    ) {}

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];
    }
}