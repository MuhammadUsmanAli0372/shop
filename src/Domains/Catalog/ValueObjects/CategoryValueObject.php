<?php

declare(strict_types=1);

namespace Domains\Catalog\ValueObjects;

class CategoryValueObject
{
    public function __construct(
        public string $name,
        public string $description,
        public null|bool $active,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
        ];
    }
}