<?php

declare(strict_types=1);

namespace Domains\Catalog\Actions;

use Domains\Catalog\Models\Category;
use Domains\Catalog\ValueObjects\CategoryValueObject;

class UpdateCategory
{
    public static function handle(CategoryValueObject $updatedCategory, Category $category)
    {
        return $category->update($updatedCategory->toArray());
    }
}