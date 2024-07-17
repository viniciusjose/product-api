<?php

use App\Application\UseCase\Sale\ListSaleUseCase;
use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Queries\Sale\ListSaleQuery;
use Carbon\Carbon;

describe('ListSaleUseCase', function () {
    beforeEach(function () {
        $this->saleRepoMock = Mockery::mock(ISaleRepository::class);

        $this->saleRepoMock
            ->shouldReceive('list')
            ->andReturn([
                [
                    'id'             => 1,
                    'customer'       => 'Customer Name',
                    'email'          => 'any_email',
                    'zip_code'       => 'any_zip_code',
                    'address'        => 'any_address',
                    'address_number' => 'any_address_number',
                    'description'    => 'any_description',
                    'amount'         => 100,
                    'taxes_amount'   => 30,
                    'total_amount'   => 130,
                    'items'          => [
                        [
                            'id'           => 1,
                            'name'         => 'Product Name',
                            'quantity'     => 1,
                            'amount'       => 100,
                            'taxes_amount' => 30,
                            'total_amount' => 130
                        ]
                    ],
                    'createdAt'      => Carbon::now(),
                    'updatedAt'      => Carbon::now()
                ]
            ]);

        $this->sut = new ListSaleUseCase($this->saleRepoMock);
    });

    it('should be instance of list Sale use case', function () {
        expect($this->sut)->toBeInstanceOf(ListSaleUseCase::class);
    });

    it('should be list Sale', function () {
        $data = $this->sut->handle(
            new ListSaleQuery(orderBy: ['name'])
        );

        expect($data)
            ->toBeArray()
            ->and($data)->not->toBeEmpty()
            ->and($data)->toHaveCount(1)
            ->and($data[0]['customer'])->toBe('Customer Name')
            ->and($data[0]['email'])->toBe('any_email')
            ->and($data[0]['amount'])->toBe(100);
    });

    test('it should be return empty if no has Sale', function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('list')
            ->andReturn([]);

        $sut = new ListSaleUseCase($repoMock);

        $data = $sut->handle(
            new ListSaleQuery(orderBy: ['name'])
        );

        expect($data)->toBeArray()
            ->and($data)->toBeEmpty();
    });
});
