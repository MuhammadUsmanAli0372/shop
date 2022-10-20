<?php

declare(strict_types=1);

namespace Domains\Catalog\Actions;

use Domains\Catalog\Factories\ProductFactory;
use Domains\Catalog\Models\Product;
use Domains\Catalog\ValueObjects\ProductValueObject;

class UpdateProduct
{
    public static function handle(ProductValueObject $updatedProduct, Product $product)
    {
        return $product->update($updatedProduct->toArray());
    }
}