<?php

declare(strict_types=1);

namespace Domains\Catalog\Actions;

use Domains\Catalog\Models\Category;

class DeleteCategory
{
    public static function handle(Category $category)
    {
        return $category->delete();
    }
}