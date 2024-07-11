<?php

namespace Tests\Unit\Application\UseCase\ProductType;

use App\Application\DTO\ProductType\UpdateProductTypeInputDto;
use App\Application\DTO\ProductType\UpdateProductTypeOutputDto;
use App\Application\UseCase\ProductType\UpdateProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\Product;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use App\Domain\Exception\ProductType\ProductTypeUpdateException;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

#[CoversClass(UpdateProductTypeUseCase::class)]
#[UsesClass(Product::class), UsesClass(UpdateProductTypeInputDto::class), UsesClass(UpdateProductTypeOutputDto::class)]
class UpdateProductTypeUseCaseTest extends TestCase
{
    protected UpdateProductTypeUseCase $sut;

    protected IProductTypeRepository $productTypeRepoMock;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->productTypeRepoMock = $this->createMock(IProductTypeRepository::class);

        $this->productTypeRepoMock
            ->method('show')
            ->willReturn(
                new ProductType(
                    name: 'Product Type Name',
                    id: 1,
                    description: 'Product Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $this->productTypeRepoMock
            ->method('getByName')
            ->willReturn(null);

        $this->productTypeRepoMock
            ->method('update')
            ->willReturn(true);

        $this->sut = $this->makeSut();
    }

    private function makeSut(): UpdateProductTypeUseCase
    {
        return new UpdateProductTypeUseCase($this->productTypeRepoMock);
    }

    #[Test]
    public function testItShouldBeInstanceOfUpdateProductTypeUseCase(): void
    {
        self::assertInstanceOf(UpdateProductTypeUseCase::class, $this->sut);
    }

    /**
     * @throws ProductTypeUpdateException
     * @throws ProductTypeNotFoundException
     * @throws ProductTypeDuplicatedException
     */
    #[Test]
    public function testItShouldBeUpdateProductType(): void
    {
        $dto = $this->sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type Name', description: 'Product Type Description')
        );

        self::assertEquals(1, $dto->id);
        self::assertEquals('Product Type Name', $dto->name);
        self::assertEquals('Product Type Description', $dto->description);
    }

    /**
     * @throws ProductTypeNotFoundException
     * @throws ProductTypeUpdateException
     * @throws Exception
     */
    #[Test]
    public function testItShouldBeThrowIfProductTypeNameExists(): void
    {
        $this->productTypeRepoMock = $this->createMock(IProductTypeRepository::class);

        $this->productTypeRepoMock
            ->method('show')
            ->willReturn(
                new ProductType(
                    name: 'Product Type Name',
                    id: 1,
                    description: 'Product Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $this->productTypeRepoMock->method('getByName')
            ->willReturn(new ProductType(name: 'Product Type New Name', description: 'Product Type Description'));

        $this->expectException(ProductTypeDuplicatedException::class);

        $sut = $this->makeSut();

        $sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type New Name', description: 'Product Type Description')
        );
    }


    /**
     * @throws ProductTypeUpdateException
     * @throws Exception
     * @throws ProductTypeDuplicatedException
     */
    #[Test]
    public function testItShouldBeThrowIfProductTypeDontExists(): void
    {
        $this->productTypeRepoMock = $this->createMock(IProductTypeRepository::class);

        $this->productTypeRepoMock
            ->method('show')
            ->willReturn(null);


        $this->expectException(ProductTypeNotFoundException::class);

        $sut = $this->makeSut();

        $sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type New Name', description: 'Product Type Description')
        );
    }

    /**
     * @throws Exception
     * @throws ProductTypeDuplicatedException
     * @throws ProductTypeNotFoundException
     */
    #[Test]
    public function testItShouldBeThrowIfProductTypeCouldNotUpdated(): void
    {
        $this->productTypeRepoMock = $this->createMock(IProductTypeRepository::class);

        $this->productTypeRepoMock
            ->method('show')
            ->willReturn(
                new ProductType(
                    name: 'Product Type Name',
                    id: 1,
                    description: 'Product Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $this->productTypeRepoMock->method('getByName')
            ->willReturn(null);

        $this->productTypeRepoMock->method('update')
            ->willReturn(false);

        $this->expectException(ProductTypeUpdateException::class);

        $sut = $this->makeSut();

        $sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type New Name', description: 'Product Type Description')
        );
    }
}
