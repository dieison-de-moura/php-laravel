<?php

namespace Tests\Unit\Entities;

use App\Entities\CategoryEntity;
use Carbon\Carbon;
use Exception;
use Tests\TestCase;

class CategoryEntityUnitTest extends TestCase
{
    public function testNewEntitySuccess(): void
    {
        $data = [
            'id'         => 1,
            'name'       => 'Test',
            'is_active'  => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        /** @var CategoryEntity $category */
        $category = new ($this->getEntityClass())($data);

        $this->assertInstanceOf(CategoryEntity::class, $category);
        $this->assertEquals($data['id'], $category->id);
        $this->assertEquals($data['name'], $category->name);
        $this->assertEquals($data['is_active'], $category->is_active);
        $this->assertEquals($data['created_at'], $category->created_at);
        $this->assertEquals($data['updated_at'], $category->updated_at);
    }

    public function testConstructError(): void
    {
        $this->expectException(Exception::class);
        $product = new CategoryEntity([]);
    }

    public function testValidate(): void
    {
        $this->expectException(Exception::class);
        $product = new CategoryEntity([]);
        $product->validate();
    }

    protected function getEntityClass(): string
    {
        return CategoryEntity::class;
    }
}
