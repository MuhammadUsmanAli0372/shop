<?php

declare(strict_types=1);

namespace Domains\Catalog\Factories;

use Domains\Catalog\ValueObjects\ProductValueObject;

class ProductFactory
{
    /**
     * @param  array  $attributes
     * @return ProductValueObject
     */
    public static function make(array $attributes): ProductValueObject
    {
        return new ProductValueObject(
            name: $attributes['name'],
            description: $attributes['description'],
            cost: (int)$attributes['cost'],
            retail: (int)$attributes['retail'],
            active: $attributes['active'] == 1 ? true : false,
            vat: $attributes['vat'] == 1 ? true : false,
            category_id: (int)$attributes['category_id'],
            range_id: (int)$attributes['range_id'],
        );
    }
}