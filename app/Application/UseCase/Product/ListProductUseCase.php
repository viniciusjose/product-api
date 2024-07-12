<?php

namespace App\Application\UseCase\Product;

use App\Domain\Contract\Repositories\Product\IListProduct;
use App\Domain\Queries\Product\ListProductQuery;

readonly class ListProductUseCase
{
    public function __construct(
        protected IListProduct $productRepository
    ) {
    }

    public function handle(ListProductQuery $input): array
    {
        return $this->productRepository->list($input);
    }
}
