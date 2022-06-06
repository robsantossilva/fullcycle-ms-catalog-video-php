<?php

namespace Tests\Unit\UseCase\Category;

use PHPUnit\Framework\TestCase;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Mockery;
use Ramsey\Uuid\Uuid;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'Category Name';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName,
        ]);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo
            ->shouldReceive('findById')
            ->with($id)
            ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(ListCategoryInputDto::class, [
            $id,
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ListCategoryOutputDto::class, $response);
        $this->assertEquals($id, $response->id);
        $this->assertEquals($categoryName, $response->name);
    }
}
