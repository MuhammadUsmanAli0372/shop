<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryResource;
use Domains\Catalog\Models\Category;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class ShowController extends Controller
{
    public function __invoke(Request $request, string $key)
    {
        $category = QueryBuilder::for(
            subject: Category::class,
        )->allowedIncludes(
            includes: ['variants', 'category', 'range'],
        )->where('key', $key)->firstOrFail();

        return response()->json(
            data: new CategoryResource(
                resource: $category
            ),
            status: Http::OK
        );
    }
}
