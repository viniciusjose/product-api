<?php

use App\Application\DTO\Tax\DestroyTaxInputDto;
use App\Application\UseCase\Tax\DestroyProductUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\ProductDestroyException;
use App\Domain\Exception\Tax\ProductNotFoundException;
use Carbon\Carbon;

describe('DestroyTaxUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(1);

        $this->sut = new DestroyProductUseCase($repoMock);
    });

    it('should be instance of destroy tax use case', function () {
        expect($this->sut)->toBeInstanceOf(DestroyProductUseCase::class);
    });

    it('should be destroy tax', function () {
        $this->sut->handle(
            new DestroyTaxInputDto(id: 1)
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if tax dont exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new DestroyProductUseCase($repoMock);

        $sut->handle(
            new DestroyTaxInputDto(id: 1)
        );
    })->throws(ProductNotFoundException::class);

    it('should be throw if tax could not be deleted', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(0);

        $sut = new DestroyProductUseCase($repoMock);

        $sut->handle(
            new DestroyTaxInputDto(id: 1)
        );
    })->throws(ProductDestroyException::class);
});
