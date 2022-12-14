<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Product;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\OrderLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;

    public function definition(): array
    {
        $variant = Product::query()->inRandomOrder()->first();

        return [
            'name' => $variant->name,
            'description' => $variant->description,
            'retail' => $variant->retail,
            'cost' => $variant->cost,
            'quantity' => $this->faker->numberBetween(1, 7),
            'purchasable_id' => $variant->id,
            'purchasable_type' => 'variant',
            'order_id' => Order::factory()->create(),
        ];
    }
}
