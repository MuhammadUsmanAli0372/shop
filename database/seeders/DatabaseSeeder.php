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
use Domains\Customer\Models\Coupon;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\OrderLine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Location::factory(5)->create();
        Address::factory()->create();
        Category::factory(5)->create();
        Range::factory(5)->create();
        Product::factory(5)->create();
        Variant::factory(5)->create();
        Cart::factory(5)->create();
        Coupon::factory(5)->create();
    }
}
