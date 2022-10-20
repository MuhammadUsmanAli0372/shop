<?php

declare(strict_types=1);

namespace Domains\Catalog\Actions;

use Domains\Catalog\Models\Product;
use Domains\Catalog\ValueObjects\ProductValueObject;

class CreateProduct
{
    public static function handle(ProductValueObject $product)
    {
        return Product::query()->create($product->toArray());
    }
}