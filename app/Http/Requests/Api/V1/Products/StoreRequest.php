<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'int',
            ],
            'retail' => [
                'required',
                'int',
            ],
            'active' => [
                'nullable',
                'boolean',
            ],
            'vat' => [
                'nullable',
                'boolean',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'range_id' => [
                'nullable',
                'exists:ranges,id',
            ],
        ];
    }
}
