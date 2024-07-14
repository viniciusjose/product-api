<?php

namespace App\Application\UseCase\Type;

use App\Application\DTO\Type\UpdateTypeInputDto;
use App\Application\DTO\Type\UpdateTypeOutputDto;
use App\Domain\Contract\Repositories\Type\IAttachTaxes;
use App\Domain\Contract\Repositories\Type\IDetachTaxes;
use App\Domain\Contract\Repositories\Type\IGetByNameType;
use App\Domain\Contract\Repositories\Type\IShowType;
use App\Domain\Contract\Repositories\Type\IUpdateType;
use App\Domain\Exception\Type\TypeDuplicatedException;
use App\Domain\Exception\Type\TypeNotFoundException;
use App\Domain\Exception\Type\TypeUpdateException;
use Carbon\Carbon;

readonly class UpdateTypeUseCase
{
    public function __construct(
        protected IUpdateType|IGetByNameType|IShowType|IAttachTaxes|IDetachTaxes $typeRepository
    ) {
    }

    /**
     * @throws TypeDuplicatedException
     * @throws TypeNotFoundException
     * @throws TypeUpdateException
     * @throws \JsonException
     */
    public function handle(UpdateTypeInputDto $input): UpdateTypeOutputDto
    {
        $type = $this->typeRepository->show($input->id);

        if ($type === null) {
            throw new TypeNotFoundException('Product type not found.');
        }

        $duplicated = $this->typeRepository->getByName($input->name);

        if ($duplicated && $type->getName() !== $duplicated?->getName()) {
            throw new TypeDuplicatedException('Product type name already exists.');
        }

        $type->setName($input->name);
        if ($input->description !== null) {
            $type->setDescription($input->description);
        }
        $type->setUpdatedAt(Carbon::now());

        $updated = $this->typeRepository->update($type);

        if (!$updated) {
            throw new TypeUpdateException('Product type could not be updated.');
        }

        if (!empty($input->taxes)) {
            $this->typeRepository->detachTaxes($type->getId());

            $this->typeRepository->attachTaxes(array_map(static fn($tax) => [
                'type_id' => $type->getId(),
                'tax_id'  => $tax['id']
            ], $input->taxes));
        }

        return new UpdateTypeOutputDto(
            id: $type->getId(),
            name: $type->getName(),
            createdAt: $type->getCreatedAt(),
            updatedAt: $type->getUpdatedAt(),
            description: $type->getDescription()
        );
    }
}
