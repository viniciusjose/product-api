<?php

use App\Application\UseCase\Type\ListTypeUseCase;
use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Queries\Type\ListTypeQuery;
use Carbon\Carbon;

describe('ListTypeUseCase', function () {
    beforeEach(function () {
        $this->typeRepoMock = Mockery::mock(ITypeRepository::class);

        $this->typeRepoMock
            ->shouldReceive('list')
            ->andReturn([
                [
                    'id'          => 1,
                    'name'        => 'Type Name',
                    'description' => 'Type Description',
                    'createdAt'   => Carbon::now(),
                    'updatedAt'   => Carbon::now()
                ]
            ]);

        $this->sut = new ListTypeUseCase($this->typeRepoMock);
    });

    it('should be instance of list type use case', function () {
        expect($this->sut)->toBeInstanceOf(ListTypeUseCase::class);
    });

    it('should be list type', function () {
        $data = $this->sut->handle(
            new ListTypeQuery(orderBy: ['name'])
        );

        expect($data)
            ->toBeArray()
            ->and($data)->not->toBeEmpty()
            ->and($data)->toHaveCount(1)
            ->and($data[0]['name'])->toBe('Type Name')
            ->and($data[0]['description'])->toBe('Type Description');
    });

    test('it should be return empty if no has type', function () {
        $repoMock = Mockery::mock(ITypeRepository::class);

        $repoMock
            ->shouldReceive('list')
            ->andReturn([]);

        $sut = new ListTypeUseCase($repoMock);

        $data = $sut->handle(
            new ListTypeQuery(orderBy: ['name'])
        );

        expect($data)->toBeArray()
            ->and($data)->toBeEmpty();
    });
});
