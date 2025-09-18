<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ProductService;
use App\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Mockery;

class ProductServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_products_calls_repository()
    {
        $paginator = Mockery::mock(LengthAwarePaginator::class);

        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $repo->shouldReceive('paginate')
            ->once()
            ->with([], 15)
            ->andReturn($paginator);

        $service = new ProductService($repo);
        $result = $service->list([], 15);

        $this->assertSame($paginator, $result);
    }

    public function test_show_product_calls_repository()
    {
        $product = new Product(['id'=>1,'name'=>'Test']);

        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $repo->shouldReceive('find')->once()->with(1)->andReturn($product);

        $service = new ProductService($repo);
        $result = $service->show(1);

        $this->assertSame($product, $result);
    }

    public function test_create_product_calls_repository()
    {
        $payload = ['name'=>'Test','slug'=>'test','price'=>10];
        $product = new Product($payload);

        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $repo->shouldReceive('create')->once()->with($payload)->andReturn($product);

        $service = new ProductService($repo);
        $result = $service->create($payload);

        $this->assertSame($product, $result);
    }

    public function test_update_product_calls_repository()
    {
        $payload = ['name'=>'Updated'];
        $product = new Product(['id'=>1,'name'=>'Updated']);

        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $repo->shouldReceive('update')->once()->with(1, $payload)->andReturn($product);

        $service = new ProductService($repo);
        $result = $service->update(1, $payload);

        $this->assertSame($product, $result);
    }

    public function test_delete_product_calls_repository()
    {
        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $repo->shouldReceive('delete')->once()->with(1)->andReturn(true);

        $service = new ProductService($repo);
        $result = $service->delete(1);

        $this->assertTrue($result);
    }
}