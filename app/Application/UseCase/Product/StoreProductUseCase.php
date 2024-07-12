<?php

namespace App\Application\UseCase\Product;

use App\Application\DTO\Product\StoreProductInputDto;
use App\Domain\Contract\Repositories\Product\IGetByNameProduct;
use App\Domain\Contract\Repositories\Product\IStoreProduct;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductDuplicatedException;
use App\Domain\Exception\Product\ProductInvalidPriceException;
use Decimal\Decimal;

readonly class StoreProductUseCase
{
    public function __construct(
        protected IStoreProduct|IGetByNameProduct $productRepository
    ) {
    }

    /**
     * @throws ProductDuplicatedException
     * @throws ProductInvalidPriceException
     */
    public function handle(StoreProductInputDto $input): void
    {
        $product = $this->productRepository->getByName($input->name);

        if ($product) {
            throw new ProductDuplicatedException('Product already exists.');
        }

        $product = new Product(
            name: $input->name,
            price: new Decimal($input->price)
        );

        $this->productRepository->store($product);
    }
}
