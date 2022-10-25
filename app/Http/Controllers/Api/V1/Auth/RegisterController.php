<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use Domains\Customer\Actions\RegisterUser;
use Domains\Customer\Factories\RegisterFactory;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        // dd("Register Roue", $request->all(), $request->validated());
        $user = RegisterUser::handle(
            object: RegisterFactory::make(
                attributes: $request->validated()
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
