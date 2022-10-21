<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Categories\StoreRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use Domains\Catalog\Actions\UpdateCategory;
use Domains\Catalog\Factories\CategoryFactory;
use Domains\Catalog\Models\Category;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class UpdateController extends Controller
{
    public function __invoke(StoreRequest $request, string $categoryKey): JsonResponse
    {
        $data = $request->validated();

        $category = Category::query()->where('key', $categoryKey)->firstOrFail();

        UpdateCategory::handle(
            updatedCategory: CategoryFactory::make(
                attributes: [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'active' => $data['active'] ?? null,
                ],
            ),
            category: $category
        );

        $category = Category::query()->where('key', $categoryKey)->firstOrFail();

        return new JsonResponse(
            data: new CategoryResource(
                resource: $category
            ),
            status: Http::ACCEPTED
        );
    }
}
