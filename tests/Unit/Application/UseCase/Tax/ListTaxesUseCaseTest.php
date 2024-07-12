<?php

use App\Application\UseCase\Tax\ListTaxesUseCase;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Queries\Tax\ListTaxesQuery;
use Carbon\Carbon;

describe('ListTaxesUseCase', function () {
    beforeEach(function () {
        $this->productTypeRepoMock = Mockery::mock(ITaxRepository::class);

        $this->productTypeRepoMock
            ->shouldReceive('list')
            ->andReturn([
                [
                    'id'         => 1,
                    'name'       => 'any_tax',
                    'percentage' => 0.2,
                    'createdAt'  => Carbon::now(),
                    'updatedAt'  => Carbon::now()
                ]
            ]);

        $this->sut = new ListTaxesUseCase($this->productTypeRepoMock);
    });

    it('should be instance of list taxes use case', function () {
        expect($this->sut)->toBeInstanceOf(ListTaxesUseCase::class);
    });

    it('should be list taxes', function () {
        $data = $this->sut->handle(
            new ListTaxesQuery(orderBy: ['name'])
        );

        expect($data)
            ->toBeArray()
            ->and($data)->not->toBeEmpty()
            ->and($data)->toHaveCount(1)
            ->and($data[0]['name'])->toBe('any_tax')
            ->and($data[0]['percentage'])->toBe(0.2);
    });

    test('it should be return empty if no has taxes', function () {
        $repoMock = Mockery::mock(ITaxRepository::class);

        $repoMock
            ->shouldReceive('list')
            ->andReturn([]);

        $sut = new ListTaxesUseCase($repoMock);

        $data = $sut->handle(
            new ListTaxesQuery(orderBy: ['name'])
        );

        expect($data)->toBeArray()
            ->and($data)->toBeEmpty();
    });
});
