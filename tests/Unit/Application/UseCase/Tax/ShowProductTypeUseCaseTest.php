<?php

use App\Application\DTO\ProductType\ShowProductTypeInputDto;
use App\Application\DTO\ProductType\ShowProductTypeOutputDto;
use App\Application\UseCase\ProductType\ShowProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use Carbon\Carbon;

describe('ShowProductTypeUseCase', function () {
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

        $this->sut = new ShowProductTypeUseCase($repoMock);
    });

    it('should be instance of show product type use case', function () {
        expect($this->sut)->toBeInstanceOf(ShowProductTypeUseCase::class);
    });

    it('should be show product type', function () {
        $data = $this->sut->handle(
            new ShowProductTypeInputDto(id: 1)
        );

        expect($data)->not->toBeNull()
            ->and($data)->toBeInstanceOf(ShowProductTypeOutputDto::class)
            ->and($data)->toHaveProperty('id')
            ->and($data->name)->toBe('Product Type Name')
            ->and($data->description)->toBe('Product Type Description');
    });

    it('should be throw if product type dont exists', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new ShowProductTypeUseCase($repoMock);

        $sut->handle(
            new ShowProductTypeInputDto(id: 1)
        );
    })->throws(ProductTypeNotFoundException::class);
});
