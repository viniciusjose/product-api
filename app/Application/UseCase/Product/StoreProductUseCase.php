<?php

namespace App\Application\UseCase\Product;

use App\Application\DTO\Product\StoreProductInputDto;
use App\Domain\Contract\Repositories\Product\IAttachTypes;
use App\Domain\Contract\Repositories\Product\IGetByNameProduct;
use App\Domain\Contract\Repositories\Product\IStoreProduct;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductDuplicatedException;
use App\Domain\Exception\Product\ProductInvalidPriceException;
use Decimal\Decimal;

readonly class StoreProductUseCase
{
    public function __construct(
        protected IStoreProduct|IGetByNameProduct|IAttachTypes $productRepository
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

        $id = $this->productRepository->store($product);

        if ($input->types) {
            $this->productRepository->attachTypes(array_map(fn ($type) => [
                'product_id' => $id,
                'type_id' => $type['id']
            ], $input->types));
        }
    }
}
