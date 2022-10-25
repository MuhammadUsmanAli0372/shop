<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\User;
use Domains\Customer\ValueObjects\LoginValueObject;
use Illuminate\Support\Facades\Auth;

class LoginUser
{
    public static function handle(LoginValueObject $attributes)
    {
        if(!Auth::attempt(['email' => $attributes->email,  'password' => $attributes->password])){
            return [
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ];
        }

        $user = User::where('email', $attributes->email)->first();

        return [
            'status' => true,
            'message' => 'User Logged In Successfully',
            'user' => $user->toArray(),
            'token' => $user->createToken("API TOKEN")->accessToken
        ];
    }
}