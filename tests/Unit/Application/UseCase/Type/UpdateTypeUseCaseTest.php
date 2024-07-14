<?php

use App\Application\DTO\Type\UpdateTypeInputDto;
use App\Application\DTO\Type\UpdateTypeOutputDto;
use App\Application\UseCase\Type\UpdateTypeUseCase;
use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeDuplicatedException;
use App\Domain\Exception\Type\TypeNotFoundException;
use App\Domain\Exception\Type\TypeUpdateException;
use Carbon\Carbon;

describe('UpdateTypeUseCase', function () {
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
            ->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock
            ->shouldReceive('update')
            ->andReturn(true);

        $repoMock
            ->shouldReceive('attachTaxes')
            ->andReturn();

        $repoMock
            ->shouldReceive('detachTaxes')
            ->andReturn();

        $this->sut = new UpdateTypeUseCase($repoMock);
    });

    it('should be instance of update type use case', function () {
        expect($this->sut)->toBeInstanceOf(UpdateTypeUseCase::class);
    });

    it('should be update type', function () {
        $dto = $this->sut->handle(
            new UpdateTypeInputDto(id: 1, name: 'Type Name', description: 'Type Description', taxes: [['id' => 1]])
        );

        expect($dto)->toBeInstanceOf(UpdateTypeOutputDto::class)
            ->and($dto)->toHaveProperty('id')
            ->and($dto->id)->toBe(1)
            ->and($dto->name)->toBe('Type Name')
            ->and($dto->description)->toBe('Type Description');
    });

    it('should be throw if type name exists', function () {
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

        $repoMock->shouldReceive('getByName')
            ->andReturn(new Type(name: 'Type New Name', description: 'Type Description'));

        $sut = new UpdateTypeUseCase($repoMock);

        $sut->handle(
            new UpdateTypeInputDto(id: 1, name: 'Type Name', description: 'Type Description', taxes: [['id' => 1]])
        );
    })->throws(TypeDuplicatedException::class);

    it('should be throw if type dont exists', function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new UpdateTypeUseCase($repoMock);

        $sut->handle(
            new UpdateTypeInputDto(id: 1, name: 'Type Name', description: 'Type Description', taxes: [['id' => 1]])
        );
    })->throws(TypeNotFoundException::class);

    it('should be throw if type could not updated', function () {
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

        $repoMock->shouldReceive('getByName')
            ->andReturn(null);

        $repoMock->shouldReceive('update')
            ->andReturn(false);

        $sut = new UpdateTypeUseCase($repoMock);

        $sut->handle(
            new UpdateTypeInputDto(id: 1, name: 'Type Name', description: 'Type Description', taxes: [['id' => 1]])
        );
    })->throws(TypeUpdateException::class);
});
