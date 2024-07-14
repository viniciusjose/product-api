<?php

namespace App\Application\UseCase\Type;

use App\Application\DTO\Type\ShowTypeInputDto;
use App\Application\DTO\Type\ShowTypeOutputDto;
use App\Domain\Contract\Repositories\Type\IShowType;
use App\Domain\Exception\Type\TypeNotFoundException;

readonly class ShowTypeUseCase
{
    public function __construct(
        protected IShowType $typeRepository
    ) {
    }

    /**
     * @throws TypeNotFoundException
     */
    public function handle(ShowTypeInputDto $input): ShowTypeOutputDto
    {
        $Type = $this->typeRepository->show($input->id);

        if ($Type === null) {
            throw new TypeNotFoundException('Product type not found.');
        }

        return new ShowTypeOutputDto(
            id: $Type->getId(),
            name: $Type->getName(),
            createdAt: $Type->getCreatedAt(),
            updatedAt: $Type->getUpdatedAt(),
            description: $Type->getDescription(),
            taxes: $Type->getTaxes()
        );
    }
}
