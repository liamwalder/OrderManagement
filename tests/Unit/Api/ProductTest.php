<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{

    use DatabaseMigrations;

    /**
     *
     */
    public function testProductCreation()
    {
        $product = factory(Product::class)->make();

        $response = $this->json('POST', '/api/products', $product->toArray());
        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name', 'price', 'description', 'units_sold','last_ordered']);
        $response->assertJsonFragment([
            'name' => $product->name,
            'price' => $product->price,
            'description' => strlen($product->description) > 150 ? substr($product->description, 0, 150)."..." : $product->description
        ]);
    }

    /**
     *
     */
    public function testProductSingle()
    {
        $product = factory(Product::class, 1)->create()->each(function($product) {
            $product->orders()->save(factory(Order::class)->create());
        });

        $product = $product->first();

        $response = $this->json('GET', '/api/product/'.$product->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'price', 'description', 'units_sold','last_ordered']);
        $response->assertJsonFragment([
            'name' => $product->name,
            'price' => $product->price,
            'description' => strlen($product->description) > 150 ? substr($product->description, 0, 150)."..." : $product->description
        ]);
    }

    /**
     *
     */
    public function testProductDeletion()
    {
        $product = factory(Product::class)->create();

        $response = $this->json('DELETE', '/api/product/'.$product->id);
        $response->assertExactJson(['deleted' => true ]);
    }

    /**
     *
     */
    public function testProductUpdate()
    {
        $product = factory(Product::class)->create();

        $updatedData = [
            'name' => 'New name',
            'price' => 12.44,
            'description' => 'New description'
        ];

        $response = $this->json('PATCH', '/api/product/'.$product->id, $updatedData);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'price', 'description', 'units_sold','last_ordered']);
        $response->assertJsonFragment([
            'name' => $updatedData['name'],
            'price' => $updatedData['price'],
            'description' => $updatedData['description']
        ]);
    }


}
