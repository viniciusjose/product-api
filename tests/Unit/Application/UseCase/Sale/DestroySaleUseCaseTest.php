<?php

use App\Application\DTO\Sale\DestroySaleInputDto;
use App\Application\UseCase\Sale\DestroySaleUseCase;
use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Entities\Sale;
use App\Domain\Exception\Sale\SaleDestroyException;
use App\Domain\Exception\Sale\SaleNotFoundException;
use Carbon\Carbon;

describe('DestroySaleUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Sale(
                    customer: 'Customer Name',
                    email: 'any_email',
                    zipCode: 'any_zip_code',
                    address: 'any_address',
                    addressNumber: 123,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(1);

        $this->sut = new DestroySaleUseCase($repoMock);
    });

    it('should be instance of destroy Sale use case', function () {
        expect($this->sut)->toBeInstanceOf(DestroySaleUseCase::class);
    });

    it('should be destroy Sale', function () {
        $this->sut->handle(
            new DestroySaleInputDto(id: 1)
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if Sale dont exists', function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new DestroySaleUseCase($repoMock);

        $sut->handle(
            new DestroySaleInputDto(id: 1)
        );
    })->throws(SaleNotFoundException::class);

    it('should be throw if Sale could not be deleted', function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Sale(
                    customer: 'Customer Name',
                    email: 'any_email',
                    zipCode: 'any_zip_code',
                    address: 'any_address',
                    addressNumber: 123,
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(0);

        $sut = new DestroySaleUseCase($repoMock);

        $sut->handle(
            new DestroySaleInputDto(id: 1)
        );
    })->throws(SaleDestroyException::class);
});
