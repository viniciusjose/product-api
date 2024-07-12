<?php

namespace App\Application\UseCase\Type;

use App\Application\DTO\Type\StoreTypeInputDto;
use App\Domain\Contract\Repositories\Type\IGetByNameType;
use App\Domain\Contract\Repositories\Type\IStoreType;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeDuplicatedException;

readonly class StoreTypeUseCase
{
    public function __construct(
        protected IStoreType|IGetByNameType $typeRepository
    ) {
    }

    /**
     * @throws TypeDuplicatedException
     */
    public function handle(StoreTypeInputDto $input): void
    {
        $Type = $this->typeRepository->getByName($input->name);

        if ($Type) {
            throw new TypeDuplicatedException('Product type already exists.');
        }

        $Type = new Type(
            name: $input->name,
            description: $input->description
        );

        $this->typeRepository->store($Type);
    }
}
