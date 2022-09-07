<?php

declare(strict_types=1);

use Domains\Fulfilment\Aggregates\OrderAggregate;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;

it('create an order for an unauthennticated user', function (CartItem $item, Location $location) {
    OrderAggregate::fake()
        ->given(
            events: new OrderWasCreated(
                cart: $item->cart->uuid,
                shipping: $location->id,
                billing: $location->id,
                user: null,
                email: 'usmanalimuhammad513@gmail.com',
            ),
        )->when(
            callable: function (OrderAggregate $aggregate) use($item, $location) {
                $aggregate->createOrder(
                    cart: $item->cart->uuid,
                    shipping: $location->id,
                    billing: $location->id,
                    user: null,
                    email: 'usmanalimuhammad513@gmail.com'
                );
            },
        )->assertRecorded(
            expectedEvents: new OrderWasCreated(
                cart: $item->cart->uuid,
                shipping: $location->id,
                billing: $location->id,
                user: null,
                email: 'usmanalimuhammad513@gmail.com'
            ) 
        );

})->with('3CartItems', 'location');

it('create an order for an authennticated user', function (CartItem $item, Location $location) {
    auth()->login(User::factory()->create());

    OrderAggregate::fake()
        ->given(
            events: new OrderWasCreated(
                cart: $item->cart->uuid,
                shipping: $location->id,
                billing: $location->id,
                user: auth()->id(),
                email: 'usmanalimuhammad513@gmail.com',
            ),
        )->when(
            callable: function (OrderAggregate $aggregate) use($item, $location) {
                $aggregate->createOrder(
                    cart: $item->cart->uuid,
                    shipping: $location->id,
                    billing: $location->id,
                    user: auth()->id(),
                    email: 'usmanalimuhammad513@gmail.com'
                );
            },
        )->assertRecorded(
            expectedEvents: new OrderWasCreated(
                cart: $item->cart->uuid,
                shipping: $location->id,
                billing: $location->id,
                user: auth()->id(),
                email: 'usmanalimuhammad513@gmail.com'
            ) 
        );

})->with('3CartItems', 'location');