<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Domains\Catalog\Models\Category;
use Domains\Catalog\Models\Product;
use Domains\Catalog\Models\Range;
use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Address;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\OrderLine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Location::factory(50)->create();
        // Address::factory()->create();
        // Category::factory(10)->create();
        // Range::factory(10)->create();
        // Product::factory(50)->create();
        Variant::factory(50)->create();
        // Cart::factory(10)->create();
        // Order::factory(50)->create();
        OrderLine::factory(20)->create();
    }
}
