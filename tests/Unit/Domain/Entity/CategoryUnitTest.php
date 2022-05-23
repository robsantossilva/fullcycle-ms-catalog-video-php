<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New Cat',
            description: 'New desc',
            isActive: true
        );

        $this->assertNotEmpty($category->id);
        $this->assertNotEmpty($category->createdAt);
        $this->assertEquals('New Cat', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            name: 'New Cat',
            isActive: false
        );
        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDesable()
    {
        $category = new Category(
            name: 'New Cat'
        );
        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'New Cat',
            description: 'New desc',
            isActive: true,
            createdAt: '2012-12-12 12:12:12'
        );

        $category->update(
            name: 'new_name',
            description: 'new_desc'
        );

        $this->assertEquals($uuid, $category->id);
        $this->assertEquals('2012-12-12 12:12:12', $category->createdAt);
        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new_desc', $category->description);
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'N',
                description: 'New Desc'
            );
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(
                name: 'New Cat',
                description: random_bytes(256)
            );
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
