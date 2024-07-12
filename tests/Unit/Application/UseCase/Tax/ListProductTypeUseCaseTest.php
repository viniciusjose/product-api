<?php

use App\Application\UseCase\ProductType\ListProductTypeUseCase;
use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Queries\ProductType\ListProductTypeQuery;
use Carbon\Carbon;

describe('ListProductTypeUseCase', function () {
    beforeEach(function () {
        $this->productTypeRepoMock = Mockery::mock(IProductTypeRepository::class);

        $this->productTypeRepoMock
            ->shouldReceive('list')
            ->andReturn([
                [
                    'id'          => 1,
                    'name'        => 'Product Type Name',
                    'description' => 'Product Type Description',
                    'createdAt'   => Carbon::now(),
                    'updatedAt'   => Carbon::now()
                ]
            ]);

        $this->sut = new ListProductTypeUseCase($this->productTypeRepoMock);
    });

    it('should be instance of list product type use case', function () {
        expect($this->sut)->toBeInstanceOf(ListProductTypeUseCase::class);
    });

    it('should be list product type', function () {
        $data = $this->sut->handle(
            new ListProductTypeQuery(orderBy: ['name'])
        );

        expect($data)
            ->toBeArray()
            ->and($data)->not->toBeEmpty()
            ->and($data)->toHaveCount(1)
            ->and($data[0]['name'])->toBe('Product Type Name')
            ->and($data[0]['description'])->toBe('Product Type Description');
    });

    test('it should be return empty if no has product type', function () {
        $repoMock = Mockery::mock(IProductTypeRepository::class);

        $repoMock
            ->shouldReceive('list')
            ->andReturn([]);

        $sut = new ListProductTypeUseCase($repoMock);

        $data = $sut->handle(
            new ListProductTypeQuery(orderBy: ['name'])
        );

        expect($data)->toBeArray()
            ->and($data)->toBeEmpty();
    });
});
