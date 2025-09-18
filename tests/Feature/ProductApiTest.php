<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson(route('products.index'));

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $category = Category::factory()->create();

        $payload = [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 100,
        ];

        $response = $this->postJson(route('products.store'), $payload);

        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'Test Product']);

        $product = Product::latest()->first();
        $product->categories()->attach($category->id);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', $product->id));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $product->id]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $payload = ['name' => 'Updated Product'];

        $response = $this->putJson(route('products.update', $product->id), $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Product']);

        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('products.destroy', $product->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
