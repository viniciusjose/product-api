<?php

use App\Application\DTO\Product\ShowProductInputDto;
use App\Application\DTO\Product\ShowProductOutputDto;
use App\Application\UseCase\Product\ShowProductUseCase;
use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductNotFoundException;
use Carbon\Carbon;
use Decimal\Decimal;

describe('ShowProductUseCase', function () {
    beforeEach(function () {
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

        $this->sut = new ShowProductUseCase($repoMock);
    });

    it('should be instance of show Product use case', function () {
        expect($this->sut)->toBeInstanceOf(ShowProductUseCase::class);
    });

    it('should be show Product', function () {
        $data = $this->sut->handle(
            new ShowProductInputDto(id: 1)
        );

        expect($data)->not->toBeNull()
            ->and($data)->toBeInstanceOf(ShowProductOutputDto::class)
            ->and($data)->toHaveProperty('id')
            ->and($data->name)->toBe('Product Name')
            ->and($data->price)->toBeInstanceOf(Decimal::class);
    });

    it('should be throw if Product dont exists', function () {
        $repoMock = Mockery::mock(IProductRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new ShowProductUseCase($repoMock);

        $sut->handle(
            new ShowProductInputDto(id: 1)
        );
    })->throws(ProductNotFoundException::class);
});
