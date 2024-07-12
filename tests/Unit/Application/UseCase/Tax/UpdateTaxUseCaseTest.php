<?php

use App\Application\DTO\Tax\UpdateTaxInputDto;
use App\Application\DTO\Tax\UpdateTaxOutputDto;
use App\Application\UseCase\Tax\UpdateProductUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\ProductDuplicatedException;
use App\Domain\Exception\Tax\ProductNotFoundException;
use App\Domain\Exception\Tax\ProductUpdateException;
use Carbon\Carbon;

describe('UpdateTaxUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax name',
                    percentage: 0.2,
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

        $this->sut = new UpdateProductUseCase($repoMock);
    });

    it('should be instance of update product type use case', function () {
        self::assertInstanceOf(UpdateProductUseCase::class, $this->sut);
    });

    it('should be update product type', function () {
        $dto = $this->sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Any tax name', percentage: 0.2)
        );

        expect($dto)->toBeInstanceOf(UpdateTaxOutputDto::class)
            ->and($dto)->toHaveProperty('id')
            ->and($dto->id)->toBe(1)
            ->and($dto->name)->toBe('Any tax name')
            ->and($dto->percentage)->toBe(0.2);
    });

    it('should be throw if product type name exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax name',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Tax(name: 'Product Type New Name', percentage: 0.2));

        $sut = new UpdateProductUseCase($repoMock);

        $sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Product Type New Name', percentage: 0.2)
        );
    })->throws(ProductDuplicatedException::class);

    it('should be throw if product type dont exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new UpdateProductUseCase($repoMock);

        $sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Product Type New Name', percentage: 0.2)
        );
    })->throws(ProductNotFoundException::class);

    it('should be throw if product type could not updated', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax name',
                    percentage: 0.2,
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
            new UpdateTaxInputDto(id: 1, name: 'Product Type New Name', percentage: 0.2)
        );
    })->throws(ProductUpdateException::class);
});


