<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Categories\StoreRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use Domains\Catalog\Actions\CreateCategory;
use Domains\Catalog\Factories\CategoryFactory;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $category = CreateCategory::handle(
            category: CategoryFactory::make(
                attributes: [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'active' => $data['active'] ?? null,
                ],
            ),
        );

        return new JsonResponse(
            data: new CategoryResource(
                resource: $category
            ),
            status: Http::CREATED
        );
    }
}
