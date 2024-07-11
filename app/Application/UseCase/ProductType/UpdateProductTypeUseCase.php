<?php

namespace App\Application\UseCase\ProductType;

use App\Application\DTO\ProductType\StoreProductTypeInputDto;
use App\Application\DTO\ProductType\UpdateProductTypeInputDto;
use App\Application\DTO\ProductType\UpdateProductTypeOutputDto;
use App\Domain\Contract\Repositories\ProductType\IGetByNameProductType;
use App\Domain\Contract\Repositories\ProductType\IShowProductType;
use App\Domain\Contract\Repositories\ProductType\IStoreProductType;
use App\Domain\Contract\Repositories\ProductType\IUpdateProductType;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use App\Domain\Exception\ProductType\ProductTypeUpdateException;
use Carbon\Carbon;

readonly class UpdateProductTypeUseCase
{
    public function __construct(
        protected IUpdateProductType|IGetByNameProductType|IShowProductType $productTypeRepository
    ) {
    }

    /**
     * @throws ProductTypeDuplicatedException
     * @throws ProductTypeNotFoundException
     * @throws ProductTypeUpdateException
     */
    public function handle(UpdateProductTypeInputDto $input): UpdateProductTypeOutputDto
    {
        $productType = $this->productTypeRepository->show($input->id);

        if ($productType === null) {
            throw new ProductTypeNotFoundException('Product type not found.');
        }

        $duplicated = $this->productTypeRepository->getByName($input->name);

        if ($duplicated && $productType->getName() !== $duplicated?->getName()) {
            throw new ProductTypeDuplicatedException('Product type name already exists.');
        }

        $productType->setName($input->name);
        $productType->setDescription($input->description);
        $productType->setUpdatedAt(Carbon::now());

        $updated = $this->productTypeRepository->update($productType);

        if (!$updated) {
            throw new ProductTypeUpdateException('Product type could not be updated.');
        }

        return new UpdateProductTypeOutputDto(
            id: $productType->getId(),
            name: $productType->getName(),
            createdAt: $productType->getCreatedAt(),
            updatedAt: $productType->getUpdatedAt(),
            description: $productType->getDescription()
        );
    }
}
