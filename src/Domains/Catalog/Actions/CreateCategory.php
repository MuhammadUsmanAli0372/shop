<?php

declare(strict_types=1);

namespace Domains\Catalog\Actions;

use Domains\Catalog\Models\Category;
use Domains\Catalog\ValueObjects\CategoryValueObject;

class CreateCategory
{
    public static function handle(CategoryValueObject $category)
    {
        return Category::query()->create($category->toArray());
    }
}