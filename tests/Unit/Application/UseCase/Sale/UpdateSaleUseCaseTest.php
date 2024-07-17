<?php

use App\Application\DTO\Sale\UpdateSaleInputDto;
use App\Application\DTO\Sale\UpdateSaleOutputDto;
use App\Application\UseCase\Sale\UpdateSaleUseCase;
use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Entities\Sale;
use App\Domain\Exception\Sale\SaleDuplicatedException;
use App\Domain\Exception\Sale\SaleNotFoundException;
use App\Domain\Exception\Sale\SaleUpdateException;
use Carbon\Carbon;
use Decimal\Decimal;

describe('UpdateSaleUseCase', function () {
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
                    items: [],
                    taxesAmount: new Decimal(0),
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('update')
            ->andReturn(true);

        $this->sut = new UpdateSaleUseCase($repoMock);
    });

    it('should be instance of update sale use case', function () {
        expect($this->sut)->toBeInstanceOf(UpdateSaleUseCase::class);
    });

    it('should be update Sale', function () {
        $dto = $this->sut->handle(
            new UpdateSaleInputDto(
                id: 1,
                customer: 'Customer Name',
                email: 'any_email',
                zipCode: 'any_zip_code',
                address: 'any_address',
                addressNumber: 123,
                description: 'any_description'
            )
        );

        expect($dto)->toBeInstanceOf(UpdateSaleOutputDto::class)
            ->and($dto)->toHaveProperty('id')
            ->and($dto->id)->toBe(1)
            ->and($dto->customer)->toBe('Customer Name')
            ->and($dto->email)->toBe('any_email')
            ->and($dto->zipCode)->toBe('any_zip_code');
    });

    it('should be throw if sale dont exists', function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new UpdateSaleUseCase($repoMock);

        $sut->handle(
            new UpdateSaleInputDto(
                id: 1,
                customer: 'Customer',
                email: 'any_email',
                zipCode: 'any_zip_code',
                address: 'any_address',
                addressNumber: 123,
                description: 'any_description'
            )
        );
    })->throws(SaleNotFoundException::class);

    it('should be throw if sale could not updated', function () {
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
                    items: [],
                    taxesAmount: new Decimal(0),
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );


        $repoMock->shouldReceive('update')
            ->andReturn(false);

        $sut = new UpdateSaleUseCase($repoMock);

        $sut->handle(
            new UpdateSaleInputDto(
                id: 1,
                customer: 'Customer',
                email: 'any_email',
                zipCode: 'any_zip_code',
                address: 'any_address',
                addressNumber: 123,
                description: 'any_description'
            )
        );
    })->throws(SaleUpdateException::class);
});
