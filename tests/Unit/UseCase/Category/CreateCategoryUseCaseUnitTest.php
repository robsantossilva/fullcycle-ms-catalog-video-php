<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateCategory()
    {
        $this->mockEntity = Mockery::mock(Category::class, [
            '1',
            'name cat'
        ]);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $useCase->execute();
    }
}
