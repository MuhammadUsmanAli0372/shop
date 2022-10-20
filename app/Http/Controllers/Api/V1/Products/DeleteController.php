<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use Domains\Catalog\Actions\DeleteProduct;
use Domains\Catalog\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, string $productKey)
    {
        $product = Product::query()->where('key', $productKey)->first();

        if ($product) {
            DeleteProduct::handle(
                product: $product
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
