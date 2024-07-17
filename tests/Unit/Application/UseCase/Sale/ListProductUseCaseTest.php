<?php

use App\Application\UseCase\Product\ListProductUseCase;
use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Queries\Product\ListProductQuery;
use Carbon\Carbon;

describe('ListProductUseCase', function () {
    beforeEach(function () {
        $this->ProductRepoMock = Mockery::mock(IProductRepository::class);

        $this->ProductRepoMock
            ->shouldReceive('list')
            ->andReturn([
                [
                    'id'        => 1,
                    'name'      => 'Product Name',
                    'price'     => 100,
                    'createdAt' => Carbon::now(),
                    'updatedAt' => Carbon::now()
                ]
            ]);

        $this->sut = new ListProductUseCase($this->ProductRepoMock);
    });

    it('should be instance of list Product use case', function () {
        expect($this->sut)->toBeInstanceOf(ListProductUseCase::class);
    });

    it('should be list Product', function () {
        $data = $this->sut->handle(
            new ListProductQuery(orderBy: ['name'])
        );

        expect($data)
            ->toBeArray()
            ->and($data)->not->toBeEmpty()
            ->and($data)->toHaveCount(1)
            ->and($data[0]['name'])->toBe('Product Name')
            ->and($data[0]['price'])->toBe(100);
    });

    test('it should be return empty if no has Product', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('list')
            ->andReturn([]);

        $sut = new ListProductUseCase($repoMock);

        $data = $sut->handle(
            new ListProductQuery(orderBy: ['name'])
        );

        expect($data)->toBeArray()
            ->and($data)->toBeEmpty();
    });
});
