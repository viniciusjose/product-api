<?php

use App\Application\DTO\Product\UpdateProductInputDto;
use App\Application\DTO\Product\UpdateProductOutputDto;
use App\Application\UseCase\Product\UpdateProductUseCase;
use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductDuplicatedException;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Exception\Product\ProductUpdateException;
use Carbon\Carbon;

describe('UpdateProductUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Product(
                    name: 'Product Name',
                    price: new Decimal\Decimal(100),
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('update')
            ->andReturn(true);

        $repoMock
            ->shouldReceive('attachTypes')
            ->andReturn();

        $repoMock
            ->shouldReceive('detachTypes')
            ->andReturn();

        $this->sut = new UpdateProductUseCase($repoMock);
    });

    it('should be instance of update Product use case', function () {
        expect($this->sut)->toBeInstanceOf(UpdateProductUseCase::class);
    });

    it('should be update Product', function () {
        $dto = $this->sut->handle(
            new UpdateProductInputDto(id: 1, name: 'Product Name', price: 100, types: [['id' => 1]])
        );

        expect($dto)->toBeInstanceOf(UpdateProductOutputDto::class)
            ->and($dto)->toHaveProperty('id')
            ->and($dto->id)->toBe(1)
            ->and($dto->name)->toBe('Product Name')
            ->and($dto->price)->toBeInstanceOf(\Decimal\Decimal::class);
    });

    it('should be throw if Product name exists', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Product(
                    name: 'Product Name',
                    price: new \Decimal\Decimal(100),
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Product(name: 'Product New Name', price: new \Decimal\Decimal(100)));

        $sut = new UpdateProductUseCase($repoMock);

        $sut->handle(
            new UpdateProductInputDto(id: 1, name: 'Product Name', price: 100, types: [['id' => 1]])
        );
    })->throws(ProductDuplicatedException::class);

    it('should be throw if Product dont exists', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new UpdateProductUseCase($repoMock);

        $sut->handle(
            new UpdateProductInputDto(id: 1, name: 'Product Name', price: 100, types: [['id' => 1]])
        );
    })->throws(ProductNotFoundException::class);

    it('should be throw if Product could not updated', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Product(
                    name: 'Product Name',
                    price: new Decimal\Decimal(100),
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock->shouldReceive('update')
            ->andReturn(false);

        $sut = new UpdateProductUseCase($repoMock);

        $sut->handle(
            new UpdateProductInputDto(id: 1, name: 'Product Name', price: 100, types: [['id' => 1]])
        );
    })->throws(ProductUpdateException::class);
});
