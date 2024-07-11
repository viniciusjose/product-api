<?php

namespace App\Application\UseCase\ProductType;

use App\Application\DTO\ProductType\DestroyProductTypeInputDto;
use App\Domain\Contract\Repositories\ProductType\IDestroyProductType;
use App\Domain\Contract\Repositories\ProductType\IShowProductType;
use App\Domain\Exception\ProductType\ProductTypeDestroyException;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;

readonly class DestroyProductTypeUseCase
{
    public function __construct(
        protected IDestroyProductType|IShowProductType $productTypeRepository
    ) {
    }

    /**
     * @throws ProductTypeNotFoundException
     * @throws ProductTypeDestroyException
     */
    public function handle(DestroyProductTypeInputDto $input): void
    {
        $productType = $this->productTypeRepository->show($input->id);

        if ($productType === null) {
            throw new ProductTypeNotFoundException('Product type not found.');
        }

        $deleted = $this->productTypeRepository->destroy($productType->getId());

        if ($deleted === 0) {
            throw new ProductTypeDestroyException('Product type could not be deleted.');
        }
    }
}
