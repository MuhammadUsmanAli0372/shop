<?php

declare(strict_types=1);

namespace Domains\Catalog\Actions;

use Domains\Catalog\Models\Product;

class DeleteProduct
{
    public static function handle(Product $product)
    {
        return $product->delete();
    }
}