<?php

use App\Application\DTO\Type\ShowTypeInputDto;
use App\Application\DTO\Type\ShowTypeOutputDto;
use App\Application\UseCase\Type\ShowTypeUseCase;
use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeNotFoundException;
use Carbon\Carbon;

describe('ShowTypeUseCase', function () {
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

        $this->sut = new ShowTypeUseCase($repoMock);
    });

    it('should be instance of show type use case', function () {
        expect($this->sut)->toBeInstanceOf(ShowTypeUseCase::class);
    });

    it('should be show type', function () {
        $data = $this->sut->handle(
            new ShowTypeInputDto(id: 1)
        );

        expect($data)->not->toBeNull()
            ->and($data)->toBeInstanceOf(ShowTypeOutputDto::class)
            ->and($data)->toHaveProperty('id')
            ->and($data->name)->toBe('Type Name')
            ->and($data->description)->toBe('Type Description');
    });

    it('should be throw if type dont exists', function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new ShowTypeUseCase($repoMock);

        $sut->handle(
            new ShowTypeInputDto(id: 1)
        );
    })->throws(TypeNotFoundException::class);
});
