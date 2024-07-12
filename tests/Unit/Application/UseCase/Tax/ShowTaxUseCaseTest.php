<?php

use App\Application\DTO\Tax\ShowTaxInputDto;
use App\Application\DTO\Tax\ShowTaxOutputDto;
use App\Application\UseCase\Tax\ShowProductUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\ProductNotFoundException;
use Carbon\Carbon;

describe('ShowTaxUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'any_name',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $this->sut = new ShowProductUseCase($repoMock);
    });

    it('should be instance of show tax use case', function () {
        expect($this->sut)->toBeInstanceOf(ShowProductUseCase::class);
    });

    it('should be show tax', function () {
        $data = $this->sut->handle(
            new ShowTaxInputDto(id: 1)
        );

        expect($data)->not->toBeNull()
            ->and($data)->toBeInstanceOf(ShowTaxOutputDto::class)
            ->and($data)->toHaveProperty('id')
            ->and($data->name)->toBe('any_name')
            ->and($data->percentage)->toBe(0.2);
    });

    it('should be throw if tax dont exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new ShowProductUseCase($repoMock);

        $sut->handle(
            new ShowTaxInputDto(id: 1)
        );
    })->throws(ProductNotFoundException::class);
});
