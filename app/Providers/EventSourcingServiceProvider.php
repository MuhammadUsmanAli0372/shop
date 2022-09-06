<?php

namespace App\Providers;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Aggregates\OrderAggregate;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Projectionist::addProjector([
            CartAggregate::class,
            OrderAggregate::class,
        ]);
    }

    public function boot(): void
    {
        //
    }
}
