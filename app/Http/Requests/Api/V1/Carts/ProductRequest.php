<?php

namespace App\Http\Requests\Api\V1\Carts;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                'gt:0',
            ],
            'purchasable_id' => [
                'required',
                'int',
            ],
            'purchasable_type' => [
                'required',
                'string',
                'in:variant,bundle',
            ],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'quantity.required' => 'quantity is required!',
            'purchasable_id.required' => 'purchasable_id is required!',
            'purchasable_type.required' => 'purchasable_type is required!'
        ];
    }
}
