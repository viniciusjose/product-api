<?php

namespace Tests\Unit\Application\UseCase\ProductType;

use App\Application\DTO\ProductType\StoreProductTypeInputDto;
use App\Application\UseCase\ProductType\StoreProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\Product;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

#[CoversClass(StoreProductTypeUseCase::class)]
#[UsesClass(Product::class), UsesClass(StoreProductTypeInputDto::class)]
class StoreProductTypeUseCaseTest extends TestCase
{
    protected StoreProductTypeUseCase $sut;

    protected IProductTypeRepository $productTypeRepoMock;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->productTypeRepoMock = $this->createMock(IProductTypeRepository::class);
        $this->productTypeRepoMock
            ->method('getByName')
            ->willReturn(null);

        $this->productTypeRepoMock
            ->method('store')
            ->willReturn(1);

        $this->sut = $this->makeSut();
    }

    private function makeSut(): StoreProductTypeUseCase
    {
        return new StoreProductTypeUseCase($this->productTypeRepoMock);
    }

    #[Test]
    public function testItShouldBeInstanceOfStoreProductTypeUseCase(): void
    {
        self::assertInstanceOf(StoreProductTypeUseCase::class, $this->sut);
    }

    /**
     * @throws ProductTypeDuplicatedException
     */
    #[Test]
    public function testItShouldBeStoreProductType(): void
    {
        $this->sut->handle(
            new StoreProductTypeInputDto(name: 'Product Type Name', description: 'Product Type Description')
        );

        self::assertTrue(true);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function testItShouldBeThrowIfProductTypeNameExists(): void
    {
        $this->productTypeRepoMock = $this->createMock(IProductTypeRepository::class);
        $this->productTypeRepoMock->method('getByName')
            ->willReturn(new ProductType(name: 'Product Type Name', description: 'Product Type Description'));

        $this->expectException(ProductTypeDuplicatedException::class);

        $sut = $this->makeSut();

        $sut->handle(
            new StoreProductTypeInputDto(name: 'Product Type Name', description: 'Product Type Description')
        );
    }
}
