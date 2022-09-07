<?php

declare(strict_types=1);

namespace App\Http\Middleware\Stripe;

use Closure;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Stripe\Stripe;
use UnexpectedValueException;

class SignatureValidationMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        Stripe::setApiKey(
            apiKey: config('services.stripe.key'),
        );

        try {
            $event = Webhook::constructEvent(
                payload: json_encode($request->all()),
                sigHeader: $request->header(
                    key: 'Stripe-Signature',
                ),
                secret: config('services.stripe.endpoint_secret')
            );
        } catch (UnexpectedValueException $e) {
            // invalid payload
            abort(code: Http::UNPROCESSABLE_ENTITY);
        } catch (SignatureVerificationException $e) {
            abort(code: Http::UNAUTHORIZED);
        }

        $request->merge([
            'payload' => $event,
        ]);

        return $next($request);
    }
}
