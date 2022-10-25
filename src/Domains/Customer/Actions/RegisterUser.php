<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\User;
use Domains\Customer\ValueObjects\RegisterValueObject;

class RegisterUser
{
    public static function handle(RegisterValueObject $object)
    {
        $user = User::create($object->toArray());

        return [
            'status' => true,
            'user' => $user->toArray(),
            'token' => $user->createToken("API TOKEN")->accessToken
        ];
    }
}