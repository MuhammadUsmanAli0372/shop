<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Products\StoreRequest;
use App\Http\Resources\Api\V1\ProductResource;
use Domains\Catalog\Actions\CreateProduct;
use Domains\Catalog\Factories\ProductFactory;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = CreateProduct::handle(
            product: ProductFactory::make(
                attributes: [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'cost' => $data['cost'],
                    'retail' => $data['retail'],
                    'active' => $data['active'] ?? null,
                    'vat' => $data['vat'] ?? null,
                    'category_id' => $data['category_id'] ?? null,
                    'range_id' => $data['range_id'] ?? null,
                ],
            ),
        );

        return new JsonResponse(
            data: new ProductResource(
                resource: $product
            ),
            status: Http::CREATED
        );
    }
}
