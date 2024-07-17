<?php

use App\Application\DTO\Sale\StoreSaleInputDto;
use App\Application\UseCase\Sale\StoreSaleUseCase;
use App\Domain\Contract\Repositories\Sale\ISaleRepository;

describe('StoreSaleUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ISaleRepository::class);

        $repoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $this->sut = new StoreSaleUseCase($repoMock);
    });

    it('should be instance of store Sale use case', function () {
        expect($this->sut)->toBeInstanceOf(StoreSaleUseCase::class);
    });

    it('should be store sale', function () {
        $this->sut->handle(
            new StoreSaleInputDto(
                customer: 'Customer',
                email: 'any_email',
                zipCode: 'any_zip_code',
                address: 'any_address',
                addressNumber: 123,
                description: 'any_description'
            )
        );

        expect(true)->toBeTrue();
    });
});
