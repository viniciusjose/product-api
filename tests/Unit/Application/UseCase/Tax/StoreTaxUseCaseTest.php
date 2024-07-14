<?php

use App\Application\DTO\Tax\StoreTaxInputDto;
use App\Application\UseCase\Tax\StoreTaxUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\TaxDuplicatedException;

describe('StoreTaxUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITaxRepository::class);
        $repoMock
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $this->sut = new StoreTaxUseCase($repoMock);
    });

    it('should be instance of store tax use case', function () {
        expect($this->sut)->toBeInstanceOf(StoreTaxUseCase::class);
    });

    it('should be store tax', function () {
        $this->sut->handle(
            new StoreTaxInputDto(name: 'Any tax nam', percentage: 0.2)
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if tax name exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Tax(name: 'Any tax nam', percentage: 0.2));

        $sut = new StoreTaxUseCase($repoMock);

        $sut->handle(
            new StoreTaxInputDto(name: 'Any tax nam', percentage: 0.2)
        );
    })->throws(TaxDuplicatedException::class);
});
