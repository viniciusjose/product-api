<?php

use App\Application\DTO\Tax\DestroyTaxInputDto;
use App\Application\UseCase\Tax\DestroyTaxUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\TaxDestroyException;
use App\Domain\Exception\Tax\TaxNotFoundException;
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

        $this->sut = new DestroyTaxUseCase($repoMock);
    });

    it('should be instance of destroy tax use case', function () {
        expect($this->sut)->toBeInstanceOf(DestroyTaxUseCase::class);
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

        $sut = new DestroyTaxUseCase($repoMock);

        $sut->handle(
            new DestroyTaxInputDto(id: 1)
        );
    })->throws(TaxNotFoundException::class);

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

        $sut = new DestroyTaxUseCase($repoMock);

        $sut->handle(
            new DestroyTaxInputDto(id: 1)
        );
    })->throws(TaxDestroyException::class);
});
