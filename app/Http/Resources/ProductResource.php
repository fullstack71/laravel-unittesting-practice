<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => (float)$this->price,
            'final_price' => (float)$this->final_price,
            'categories' => $this->whenLoaded('categories', $this->categories->map->only(['id','name','slug'])),
            'tags' => $this->whenLoaded('tags', $this->tags->map->only(['id','name','slug'])),
            'variations' => $this->whenLoaded('variations', $this->variations->map(function($v){
                return [
                    'id' => $v->id,
                    'name' => $v->name,
                    'options' => $v->options->map->only(['id','value','sku','price_modifier','stock']),
                ];
            })),
            'discounts' => $this->whenLoaded('discounts', $this->discounts->map->only(['id','type','value','starts_at','ends_at'])),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}