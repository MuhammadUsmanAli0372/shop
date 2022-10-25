<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use Domains\Customer\Actions\LoginUser;
use Domains\Customer\Factories\LoginFactory;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $user = LoginUser::handle(
            attributes: LoginFactory::make(
                attributes: $request->validated(),
            ),
        );

        if (data_get($user, 'status') == true) {
            return response()->json($user, 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Email & Password does not match with our record.',
        ], 401);
    }
}
