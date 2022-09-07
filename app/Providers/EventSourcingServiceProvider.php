<?php

namespace App\Providers;

use Domains\Customer\Aggregates\CartAggregate;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Projectionist::addProjector([
            CartAggregate::class,
        ]);
    }

    public function boot(): void
    {
        //
    }
}
