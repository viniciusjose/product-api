<?php

namespace App\Application\UseCase\Type;

use App\Application\DTO\Type\StoreTypeInputDto;
use App\Domain\Contract\Repositories\Type\IAttachTaxes;
use App\Domain\Contract\Repositories\Type\IGetByNameType;
use App\Domain\Contract\Repositories\Type\IStoreType;
use App\Domain\Entities\Type;
use App\Domain\Exception\Type\TypeDuplicatedException;

readonly class StoreTypeUseCase
{
    public function __construct(
        protected IStoreType|IGetByNameType|IAttachTaxes $typeRepository
    ) {
    }

    /**
     * @throws TypeDuplicatedException
     */
    public function handle(StoreTypeInputDto $input): void
    {
        $type = $this->typeRepository->getByName($input->name);

        if ($type) {
            throw new TypeDuplicatedException('Product type already exists.');
        }

        $type = new Type(
            name: $input->name,
            description: $input->description
        );

        $typeId = $this->typeRepository->store($type);

        if ($input->taxes) {
            $this->typeRepository->attachTaxes(array_map(fn ($tax) => [
                'type_id' => $typeId,
                'tax_id' => $tax['id']
            ], $input->taxes));
        }
    }
}
