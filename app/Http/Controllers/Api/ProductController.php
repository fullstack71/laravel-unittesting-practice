<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = (int)$request->get('per_page', 15);
        $filters = $request->only(['q','category_id','tag_id']);
        $products = $this->service->list($filters, $perPage);

        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = $this->service->show((int)$id);
        if (! $product) return response()->json(['message'=>'Not found'],404);
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->service->create($request->validated());
        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->service->update((int)$id, $request->validated());
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $this->service->delete((int)$id);
        return response()->json([],204);
    }
}