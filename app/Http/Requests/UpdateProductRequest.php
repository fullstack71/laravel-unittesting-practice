<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('product') ? $this->route('product')->id ?? $this->route('product') : null;

        return [
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:products,slug,' . $id,
            'sku' => 'sometimes|nullable|string|unique:products,sku,' . $id,
            'price' => 'sometimes|numeric|min:0',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}