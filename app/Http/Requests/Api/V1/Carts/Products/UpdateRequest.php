<?php

namespace App\Http\Requests\Api\V1\Carts\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                'required',
                'int',
                'min:0',
            ]
        ];
    }
}
