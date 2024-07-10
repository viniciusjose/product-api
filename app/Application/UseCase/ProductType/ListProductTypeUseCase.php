<?php

namespace App\Application\UseCase\ProductType;

use App\Domain\Contract\Repositories\ProductType\IListProductType;
use App\Domain\Queries\ProductType\ListProductTypeQuery;

readonly class ListProductTypeUseCase
{
    public function __construct(
        protected IListProductType $productTypeRepository
    ) {
    }

    public function handle(ListProductTypeQuery $input): array
    {
        return $this->productTypeRepository->list($input);
    }
}
