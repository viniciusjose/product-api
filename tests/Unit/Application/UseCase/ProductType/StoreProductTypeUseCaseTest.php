<?php

use App\Application\DTO\ProductType\StoreProductTypeInputDto;
use App\Application\UseCase\ProductType\StoreProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;

describe('StoreProductTypeUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);
        $repoMock
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $this->sut = new StoreProductTypeUseCase($repoMock);
    });

    it('should be instance of store product type use case', function () {
        expect($this->sut)->toBeInstanceOf(StoreProductTypeUseCase::class);
    });

    it('should be store product type', function () {
        $this->sut->handle(
            new StoreProductTypeInputDto(name: 'Product Type Name', description: 'Product Type Description')
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if product type name exists', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock->shouldReceive('getByName')
            ->andReturn(new ProductType(name: 'Product Type Name', description: 'Product Type Description'));

        $sut = new StoreProductTypeUseCase($repoMock);

        $sut->handle(
            new StoreProductTypeInputDto(name: 'Product Type Name', description: 'Product Type Description')
        );
    })->throws(ProductTypeDuplicatedException::class);
});