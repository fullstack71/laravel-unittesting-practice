<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query()->with(['categories','tags','variations.options','discounts']);

        if (!empty($filters['q'])) {
            $query->where('name','like','%'.$filters['q'].'%');
        }

        if (isset($filters['category_id'])) {
            $query->whereHas('categories', function($q) use ($filters){
                $q->where('categories.id', $filters['category_id']);
            });
        }

        if (isset($filters['tag_id'])) {
            $query->whereHas('tags', function($q) use ($filters){
                $q->where('tags.id', $filters['tag_id']);
            });
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Product
    {
        return Product::with(['categories','tags','variations.options','discounts'])->find($id);
    }

    public function create(array $data): Product
    {
        $relations = [];
        if (isset($data['categories'])) $relations['categories'] = $data['categories'];
        if (isset($data['tags'])) $relations['tags'] = $data['tags'];

        $productData = collect($data)
                        ->except(['categories','tags','variations','discounts'])
                        ->toArray();

        $product = Product::create($productData);

        if (!empty($relations['categories'])) $product->categories()->sync($relations['categories']);
        if (!empty($relations['tags'])) $product->tags()->sync($relations['tags']);

        if (!empty($data['variations'])) {
            foreach ($data['variations'] as $v) {
                $variation = $product->variations()->create(['name' => $v['name']]);
                foreach ($v['options'] ?? [] as $opt) {
                    $variation->options()->create($opt);
                }
            }
        }

        if (!empty($data['discounts'])) {
            foreach ($data['discounts'] as $d) {
                $product->discounts()->create($d);
            }
        }

        return $product->fresh(['categories','tags','variations.options','discounts']);
    }

    public function update(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);

        $relations = [];
        if (isset($data['categories'])) $relations['categories'] = $data['categories'];
        if (isset($data['tags'])) $relations['tags'] = $data['tags'];

        $productData = collect($data)
                        ->except(['categories','tags','variations','discounts'])
                        ->toArray();

        $product->update($productData);

        if (array_key_exists('categories', $relations)) $product->categories()->sync($relations['categories']);
        if (array_key_exists('tags', $relations)) $product->tags()->sync($relations['tags']);

        // variations: For simplicity we replace provided variations (good for API usage).
        if (isset($data['variations'])) {
            $product->variations()->delete();
            foreach ($data['variations'] as $v) {
                $variation = $product->variations()->create(['name' => $v['name']]);
                foreach ($v['options'] ?? [] as $opt) {
                    $variation->options()->create($opt);
                }
            }
        }

        if (isset($data['discounts'])) {
            $product->discounts()->delete();
            foreach ($data['discounts'] as $d) {
                $product->discounts()->create($d);
            }
        }

        return $product->fresh(['categories','tags','variations.options','discounts']);
    }

    public function delete(int $id): bool
    {
        $product = Product::findOrFail($id);
        return (bool)$product->delete();
    }
}