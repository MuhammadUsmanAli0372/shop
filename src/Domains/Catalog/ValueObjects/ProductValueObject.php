<?php

declare(strict_types=1);

namespace Domains\Catalog\ValueObjects;

class ProductValueObject
{
    public function __construct(
        public string $name,
        public string $description,
        public int $cost,
        public int $retail,
        public null|bool $active,
        public null|bool $vat,
        public null|int $category_id,
        public null|int $range_id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'retail' => $this->retail,
            'active' => $this->active,
            'vat' => $this->vat,
            'category_id' => $this->category_id,
            'range_id' => $this->range_id,
        ];
    }
}