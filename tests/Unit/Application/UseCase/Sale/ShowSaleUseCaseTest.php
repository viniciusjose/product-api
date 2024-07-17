<?php

use App\Application\DTO\Sale\ShowSaleInputDto;
use App\Application\DTO\Sale\ShowSaleOutputDto;
use App\Application\UseCase\Sale\ShowSaleUseCase;
use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Entities\Sale;
use App\Domain\Exception\Sale\SaleNotFoundException;
use Carbon\Carbon;
use Decimal\Decimal;

describe('ShowSaleUseCase', function () {
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

        $this->sut = new ShowSaleUseCase($repoMock);
    });

    it('should be instance of show Sale use case', function () {
        expect($this->sut)->toBeInstanceOf(ShowSaleUseCase::class);
    });

    it('should be show Sale', function () {
        $data = $this->sut->handle(
            new ShowSaleInputDto(id: 1)
        );

        expect($data)->not->toBeNull()
            ->and($data)->toBeInstanceOf(ShowSaleOutputDto::class)
            ->and($data)->toHaveProperty('id')
            ->and($data->customer)->toBe('Customer Name')
            ->and($data->taxesAmount)->toBeInstanceOf(Decimal::class)
            ->and($data->taxesAmount)->toBeInstanceOf(Decimal::class);
    });

    it('should be throw if Sale dont exists', function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new ShowSaleUseCase($repoMock);

        $sut->handle(
            new ShowSaleInputDto(id: 1)
        );
    })->throws(SaleNotFoundException::class);
});
