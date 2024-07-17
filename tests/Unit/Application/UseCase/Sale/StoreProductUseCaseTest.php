<?php

use App\Application\DTO\Product\StoreProductInputDto;
use App\Application\UseCase\Product\StoreProductUseCase;
use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductDuplicatedException;
use Decimal\Decimal;

describe('StoreProductUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(IProductRepository::class);
        $repoMock
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $repoMock
            ->shouldReceive('attachTypes')
            ->andReturn();

        $this->sut = new StoreProductUseCase($repoMock);
    });

    it('should be instance of store Product use case', function () {
        expect($this->sut)->toBeInstanceOf(StoreProductUseCase::class);
    });

    it('should be store Product', function () {
        $this->sut->handle(
            new StoreProductInputDto(name: 'Product Name', price: 100, types: [['id' => 1]])
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if Product name exists', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Product(name: 'Product Name', price: new Decimal(100)));

        $sut = new StoreProductUseCase($repoMock);

        $sut->handle(
            new StoreProductInputDto(name: 'Product Name', price: 100, types: [['id' => 1]])
        );
    })->throws(ProductDuplicatedException::class);
});
