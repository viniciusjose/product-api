<?php

use App\Application\DTO\ProductType\UpdateProductTypeInputDto;
use App\Application\DTO\ProductType\UpdateProductTypeOutputDto;
use App\Application\UseCase\ProductType\UpdateProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use App\Domain\Exception\ProductType\ProductTypeUpdateException;
use Carbon\Carbon;

describe('UpdateProductTypeUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new ProductType(
                    name: 'Product Type Name',
                    id: 1,
                    description: 'Product Type Description',
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

        $this->sut = new UpdateProductTypeUseCase($repoMock);
    });

    test('it should be instance of update product type use case', function () {
        self::assertInstanceOf(UpdateProductTypeUseCase::class, $this->sut);
    });

    test('it should be update product type', function () {
        $dto = $this->sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type Name', description: 'Product Type Description')
        );

        expect($dto)->toBeInstanceOf(UpdateProductTypeOutputDto::class)
            ->and($dto)->toHaveProperty('id')
            ->and($dto->id)->toBe(1)
            ->and($dto->name)->toBe('Product Type Name')
            ->and($dto->description)->toBe('Product Type Description');
    });

    test('it should be throw if product type name exists', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new ProductType(
                    name: 'Product Type Name',
                    id: 1,
                    description: 'Product Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(new ProductType(name: 'Product Type New Name', description: 'Product Type Description'));

        $sut = new UpdateProductTypeUseCase($repoMock);

        $sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type New Name', description: 'Product Type Description')
        );
    })->throws(ProductTypeDuplicatedException::class);

    test('it should be throw if product type dont exists', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new UpdateProductTypeUseCase($repoMock);

        $sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type New Name', description: 'Product Type Description')
        );
    })->throws(ProductTypeNotFoundException::class);

    test('it should be throw if product type could not updated', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new ProductType(
                    name: 'Product Type Name',
                    id: 1,
                    description: 'Product Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock->shouldReceive('update')
            ->andReturn(false);

        $sut = new UpdateProductTypeUseCase($repoMock);

        $sut->handle(
            new UpdateProductTypeInputDto(id: 1, name: 'Product Type New Name', description: 'Product Type Description')
        );
    })->throws(ProductTypeUpdateException::class);
});

