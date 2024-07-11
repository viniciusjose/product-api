<?php

namespace App\Application\UseCase\ProductType;

use App\Application\DTO\ProductType\ShowProductTypeInputDto;
use App\Application\DTO\ProductType\ShowProductTypeOutputDto;
use App\Domain\Contract\Repositories\ProductType\IShowProductType;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;

readonly class ShowProductTypeUseCase
{
    public function __construct(
        protected IShowProductType $productTypeRepository
    ) {
    }

    /**
     * @throws ProductTypeNotFoundException
     */
    public function handle(ShowProductTypeInputDto $input): ShowProductTypeOutputDto
    {
        $productType = $this->productTypeRepository->show($input->id);

        if ($productType === null) {
            throw new ProductTypeNotFoundException('Product type not found.');
        }

        return new ShowProductTypeOutputDto(
            id: $productType->getId(),
            name: $productType->getName(),
            createdAt: $productType->getCreatedAt(),
            updatedAt: $productType->getUpdatedAt(),
            description: $productType->getDescription()
        );
    }
}
