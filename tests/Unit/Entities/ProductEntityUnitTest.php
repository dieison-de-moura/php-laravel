<?php

namespace Tests\Unit\Entities;

use App\Entities\ProductEntity;
use DateTime;
use Exception;
use Tests\TestCase;

class ProductEntityUnitTest extends TestCase
{
    protected array $productData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productData = [
            'name'        => 'Product name',
            'description' => 'Product description',
            'price'       => 999.99,
            'stock'       => 10,
            'category_id' => 1,
            'is_active'   => true,
            'created_at'  => new DateTime(),
            'updated_at'  => new DateTime(),
        ];
    }

    public function testCanCreateAProductEntity()
    {
        $product = new ($this->getEntityClass())($this->productData);

        $this->assertInstanceOf($this->getEntityClass(), $product);
        $this->assertEquals('Product name', $product->name);
        $this->assertEquals('Product description', $product->description);
        $this->assertEquals(999.99, $product->price);
        $this->assertEquals(10, $product->stock);
        $this->assertEquals(1, $product->category_id);
        $this->assertTrue($product->is_active);
        $this->assertInstanceOf(DateTime::class, $product->created_at);
        $this->assertInstanceOf(DateTime::class, $product->updated_at);
    }

    public function testThrowsAnExceptionIfNameIsNotSet()
    {
        $this->expectException(Exception::class);

        unset($this->productData['name']);

        new ($this->getEntityClass())($this->productData);
    }

    public function testCanCastValuesCorrectly()
    {
        $productData = [
            'name'        => 'Product 2',
            'description' => 'Another product',
            'price'       => '199.99',
            'stock'       => '50',
            'category_id' => '2',
            'is_active'   => '1',
            'created_at'  => '2024-01-01 12:00:00',
            'updated_at'  => '2024-01-01 12:00:00',
        ];

        $product = new ($this->getEntityClass())($productData);

        $this->assertInstanceOf($this->getEntityClass(), $product);
        $this->assertEquals('Product 2', $product->name);
        $this->assertEquals('Another product', $product->description);
        $this->assertEquals(199.99, $product->price);
        $this->assertEquals(50, $product->stock);
        $this->assertEquals(2, $product->category_id);
        $this->assertTrue($product->is_active);
        $this->assertInstanceOf(DateTime::class, $product->created_at);
        $this->assertInstanceOf(DateTime::class, $product->updated_at);
    }

    public function testCanConvertProductToArray()
    {
        $product = new ($this->getEntityClass())($this->productData);

        $productArray = $product->toArray();

        $this->assertIsArray($productArray);
        $this->assertArrayHasKey('name', $productArray);
        $this->assertArrayHasKey('price', $productArray);
        $this->assertArrayHasKey('created_at', $productArray);
    }

    public function testCanConvertProductToJson()
    {
        $product = new ($this->getEntityClass())($this->productData);

        $json = $product->toJson();

        $this->assertJson($json);
        $this->assertStringContainsString('"name":"Product name"', $json);
    }

    public function testCanHandleNullValues()
    {
        $productDataWithNulls = [
            'name'        => 'Product 3',
            'description' => null,
            'price'       => 10,
            'stock'       => 0,
            'category_id' => 3,
            'is_active'   => false,
            'created_at'  => null,
            'updated_at'  => null,
        ];

        $product = new ($this->getEntityClass())($productDataWithNulls);

        $this->assertNull($product->created_at);
        $this->assertNull($product->updated_at);
        $this->assertFalse($product->is_active);
    }

    protected function getEntityClass(): string
    {
        return ProductEntity::class;
    }
}
