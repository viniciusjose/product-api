<?php

use App\Application\DTO\Type\DestroyTypeInputDto;
use App\Application\UseCase\Type\DestroyTypeUseCase;
use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeDestroyException;
use App\Domain\Exception\Type\TypeNotFoundException;
use Carbon\Carbon;

describe('DestroyTypeUseCase', function () {
    beforeEach(function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Type(
                    name: 'Type Name',
                    id: 1,
                    description: 'Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(1);

        $this->sut = new DestroyTypeUseCase($repoMock);
    });

    it('should be instance of destroy type use case', function () {
        expect($this->sut)->toBeInstanceOf(DestroyTypeUseCase::class);
    });

    it('should be destroy type', function () {
        $this->sut->handle(
            new DestroyTypeInputDto(id: 1)
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if type dont exists', function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new DestroyTypeUseCase($repoMock);

        $sut->handle(
            new DestroyTypeInputDto(id: 1)
        );
    })->throws(TypeNotFoundException::class);

    it('should be throw if product could not be deleted', function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Type(
                    name: 'Type Name',
                    id: 1,
                    description: 'Type Description',
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $repoMock
            ->shouldReceive('destroy')
            ->andReturn(0);

        $sut = new DestroyTypeUseCase($repoMock);

        $sut->handle(
            new DestroyTypeInputDto(id: 1)
        );
    })->throws(TypeDestroyException::class);
});
