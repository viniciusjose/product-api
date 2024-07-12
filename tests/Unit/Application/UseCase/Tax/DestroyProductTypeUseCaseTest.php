<?php

use App\Application\DTO\ProductType\DestroyProductTypeInputDto;
use App\Application\UseCase\ProductType\DestroyProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use Carbon\Carbon;

describe('DestroyProductTypeUseCase', function () {
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
            ->shouldReceive('destroy')
            ->andReturn(1);

        $this->sut = new DestroyProductTypeUseCase($repoMock);
    });

    it('should be instance of destroy product type use case', function () {
        expect($this->sut)->toBeInstanceOf(DestroyProductTypeUseCase::class);
    });

    it('should be destroy product type', function () {
        $this->sut->handle(
            new DestroyProductTypeInputDto(id: 1)
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if product type dont exists', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new DestroyProductTypeUseCase($repoMock);

        $sut->handle(
            new DestroyProductTypeInputDto(id: 1)
        );
    })->throws(ProductTypeNotFoundException::class);
});
