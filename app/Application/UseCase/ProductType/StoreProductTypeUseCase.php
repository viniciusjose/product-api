<?php

namespace App\Application\UseCase\ProductType;

use App\Application\DTO\ProductType\StoreProductTypeInputDto;
use App\Domain\Contract\Repositories\ProductType\IGetByNameProductType;
use App\Domain\Contract\Repositories\ProductType\IStoreProductType;
use App\Domain\Entities\ProductType;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;

readonly class StoreProductTypeUseCase
{
    public function __construct(
        protected IStoreProductType|IGetByNameProductType $productTypeRepository
    ) {
    }

    /**
     * @throws ProductTypeDuplicatedException
     */
    public function handle(StoreProductTypeInputDto $input): void
    {
        $productType = $this->productTypeRepository->getByName($input->name);

        if ($productType) {
            throw new ProductTypeDuplicatedException('Product type already exists.');
        }

        $productType = new ProductType(
            name: $input->name,
            description: $input->description
        );

        $this->productTypeRepository->store($productType);
    }
}
