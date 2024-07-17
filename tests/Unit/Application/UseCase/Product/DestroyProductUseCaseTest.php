<?php

use App\Application\DTO\Product\DestroyProductInputDto;
use App\Application\UseCase\Product\DestroyProductUseCase;
use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductDestroyException;
use App\Domain\Exception\Product\ProductInvalidPriceException;
use App\Domain\Exception\Product\ProductNotFoundException;
use Carbon\Carbon;
use Decimal\Decimal;

describe('DestroyProductUseCase', function () {
    beforeEach(/** @throws  ProductInvalidPriceException */ function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Product(
                    name: 'Product Name',
                    price: new Decimal(10),
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(1);

        $this->sut = new DestroyProductUseCase($repoMock);
    });

    it('should be instance of destroy Product use case', function () {
        expect($this->sut)->toBeInstanceOf(DestroyProductUseCase::class);
    });

    it('should be destroy Product', function () {
        $this->sut->handle(
            new DestroyProductInputDto(id: 1)
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if Product dont exists', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new DestroyProductUseCase($repoMock);

        $sut->handle(
            new DestroyProductInputDto(id: 1)
        );
    })->throws(ProductNotFoundException::class);

    it('should be throw if product could not be deleted', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Product(
                    name: 'Product Name',
                    price: new Decimal(100),
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(0);

        $sut = new DestroyProductUseCase($repoMock);

        $sut->handle(
            new DestroyProductInputDto(id: 1)
        );
    })->throws(ProductDestroyException::class);
});
