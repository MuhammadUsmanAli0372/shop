<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryResource;
use Domains\Catalog\Models\Category;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = QueryBuilder::for(
            subject: Category::class,
        )
        ->allowedIncludes(
            includes: ['products']
        )
        ->allowedFilters(
            filters: ['name', 'active']
        )
        ->paginate();

        return response()->json(
            data: CategoryResource::collection(
                resource: $categories
            ),
            status: Http::OK
        );
    }
}
