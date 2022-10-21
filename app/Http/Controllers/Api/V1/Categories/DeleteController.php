<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use Domains\Catalog\Actions\DeleteCategory;
use Domains\Catalog\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, string $categoryKey)
    {
        $category = Category::query()->where('key', $categoryKey)->first();

        if ($category) {
            DeleteCategory::handle(
                category: $category
            );

            return new Response(
                content: ['message' => 'Product Deleted SuccessFully!'],
                status: Http::ACCEPTED
            );
        } else {
            return new Response(
                content: ['message' => 'Product is not Exist!'],
                status: Http::OK
            );
        }
    }
}
