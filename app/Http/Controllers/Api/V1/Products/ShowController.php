<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductResource;
use Domains\Catalog\Models\Product;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class ShowController extends Controller
{
    public function __invoke(Request $request, string $key)
    {
        $product = QueryBuilder::for(
            subject: Product::class,
        )->allowedIncludes(
            includes: ['variants', 'category', 'range'],
        )->where('key', $key)->firstOrFail();

        return response()->json(
            data: new ProductResource(
                resource: $product
            ),
            status: Http::OK
        );
    }
}
