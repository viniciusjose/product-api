<?php

use App\Application\DTO\Tax\UpdateTaxInputDto;
use App\Application\DTO\Tax\UpdateTaxOutputDto;
use App\Application\UseCase\Tax\UpdateTaxUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\TaxDuplicatedException;
use App\Domain\Exception\Tax\TaxNotFoundException;
use App\Domain\Exception\Tax\TaxUpdateException;
use Carbon\Carbon;

describe('UpdateTaxUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax name',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('update')
            ->andReturn(true);

        $this->sut = new UpdateTaxUseCase($repoMock);
    });

    it('should be instance of update Tax type use case', function () {
        self::assertInstanceOf(UpdateTaxUseCase::class, $this->sut);
    });

    it('should be update Tax type', function () {
        $dto = $this->sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Any tax name', percentage: 0.2)
        );

        expect($dto)->toBeInstanceOf(UpdateTaxOutputDto::class)
            ->and($dto)->toHaveProperty('id')
            ->and($dto->id)->toBe(1)
            ->and($dto->name)->toBe('Any tax name')
            ->and($dto->percentage)->toBe(0.2);
    });

    it('should be throw if Tax type name exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax name',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Tax(name: 'Tax Type New Name', percentage: 0.2));

        $sut = new UpdateTaxUseCase($repoMock);

        $sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Tax Type New Name', percentage: 0.2)
        );
    })->throws(TaxDuplicatedException::class);

    it('should be throw if Tax type dont exists', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new UpdateTaxUseCase($repoMock);

        $sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Tax Type New Name', percentage: 0.2)
        );
    })->throws(TaxNotFoundException::class);

    it('should be throw if Tax type could not updated', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Tax(
                    name: 'Any tax name',
                    percentage: 0.2,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock->shouldReceive('update')
            ->andReturn(false);

        $sut = new UpdateTaxUseCase($repoMock);

        $sut->handle(
            new UpdateTaxInputDto(id: 1, name: 'Tax Type New Name', percentage: 0.2)
        );
    })->throws(TaxUpdateException::class);
});


