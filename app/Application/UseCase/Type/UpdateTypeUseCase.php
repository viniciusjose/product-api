<?php

namespace App\Application\UseCase\Type;

use App\Application\DTO\Type\StoreTypeInputDto;
use App\Application\DTO\Type\UpdateTypeInputDto;
use App\Application\DTO\Type\UpdateTypeOutputDto;
use App\Domain\Contract\Repositories\Type\IGetByNameType;
use App\Domain\Contract\Repositories\Type\IShowType;
use App\Domain\Contract\Repositories\Type\IStoreType;
use App\Domain\Contract\Repositories\Type\IUpdateType;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeDuplicatedException;
use App\Domain\Exception\Type\TypeNotFoundException;
use App\Domain\Exception\Type\TypeUpdateException;
use Carbon\Carbon;

readonly class UpdateTypeUseCase
{
    public function __construct(
        protected IUpdateType|IGetByNameType|IShowType $typeRepository
    ) {
    }

    /**
     * @throws TypeDuplicatedException
     * @throws TypeNotFoundException
     * @throws TypeUpdateException
     */
    public function handle(UpdateTypeInputDto $input): UpdateTypeOutputDto
    {
        $Type = $this->typeRepository->show($input->id);

        if ($Type === null) {
            throw new TypeNotFoundException('Product type not found.');
        }

        $duplicated = $this->typeRepository->getByName($input->name);

        if ($duplicated && $Type->getName() !== $duplicated?->getName()) {
            throw new TypeDuplicatedException('Product type name already exists.');
        }

        $Type->setName($input->name);
        $Type->setDescription($input->description);
        $Type->setUpdatedAt(Carbon::now());

        $updated = $this->typeRepository->update($Type);

        if (!$updated) {
            throw new TypeUpdateException('Product type could not be updated.');
        }

        return new UpdateTypeOutputDto(
            id: $Type->getId(),
            name: $Type->getName(),
            createdAt: $Type->getCreatedAt(),
            updatedAt: $Type->getUpdatedAt(),
            description: $Type->getDescription()
        );
    }
}
