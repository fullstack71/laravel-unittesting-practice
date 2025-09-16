<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // adjust to auth
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id',
            'variations' => 'sometimes|array',
            'variations.*.name' => 'required_with:variations|string',
            'variations.*.options' => 'sometimes|array',
            'variations.*.options.*.value' => 'required_with:variations|string',
            'variations.*.options.*.price_modifier' => 'sometimes|numeric',
        ];
    }
}