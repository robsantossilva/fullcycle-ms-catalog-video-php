<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\{
    CreateCategoryInputDto,
    CreateCategoryOutputDto,
};
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateCategory()
    {

        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Category Name';


        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CreateCategoryInputDto::class, [
            $categoryName,
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $resposeUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CreateCategoryOutputDto::class, $resposeUseCase);
        $this->assertEquals($uuid, $resposeUseCase->id);
        $this->assertEquals($categoryName, $resposeUseCase->name);

        /**
         * Spies
         */
        $this->mockRepoSpy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepoSpy->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->mockRepoSpy);
        $resposeUseCase = $useCase->execute($this->mockInputDto);
        $this->mockRepoSpy->shouldHaveReceived('insert')->once();

        Mockery::close();
    }
}
