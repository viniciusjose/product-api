<?php

use App\Application\DTO\Type\StoreTypeInputDto;
use App\Application\UseCase\Type\StoreTypeUseCase;
use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeDuplicatedException;

describe('StoreTypeUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITypeRepository::class);
        $repoMock
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $this->sut = new StoreTypeUseCase($repoMock);
    });

    it('should be instance of store type use case', function () {
        expect($this->sut)->toBeInstanceOf(StoreTypeUseCase::class);
    });

    it('should be store type', function () {
        $this->sut->handle(
            new StoreTypeInputDto(name: 'Type Name', description: 'Type Description')
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if type name exists', function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Type(name: 'Type Name', description: 'Type Description'));

        $sut = new StoreTypeUseCase($repoMock);

        $sut->handle(
            new StoreTypeInputDto(name: 'Type Name', description: 'Type Description')
        );
    })->throws(TypeDuplicatedException::class);
});
