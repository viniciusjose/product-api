<?php

namespace App\Application\UseCase\Product;

use App\Application\DTO\Product\StoreProductInputDto;
use App\Application\DTO\Product\UpdateProductInputDto;
use App\Application\DTO\Product\UpdateProductOutputDto;
use App\Domain\Contract\Repositories\Product\IAttachTypes;
use App\Domain\Contract\Repositories\Product\IDetachTypes;
use App\Domain\Contract\Repositories\Product\IGetByNameProduct;
use App\Domain\Contract\Repositories\Product\IShowProduct;
use App\Domain\Contract\Repositories\Product\IStoreProduct;
use App\Domain\Contract\Repositories\Product\IUpdateProduct;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductDuplicatedException;
use App\Domain\Exception\Product\ProductInvalidPriceException;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Exception\Product\ProductUpdateException;
use Carbon\Carbon;
use Decimal\Decimal;

readonly class UpdateProductUseCase
{
    public function __construct(
        protected IUpdateProduct|IGetByNameProduct|IShowProduct|IAttachTypes|IDetachTypes $productRepository
    ) {
    }

    /**
     * @throws ProductDuplicatedException
     * @throws ProductNotFoundException
     * @throws ProductUpdateException
     * @throws ProductInvalidPriceException
     */
    public function handle(UpdateProductInputDto $input): UpdateProductOutputDto
    {
        $product = $this->productRepository->show($input->id);

        if ($product === null) {
            throw new ProductNotFoundException('Product not found.');
        }

        $duplicated = $this->productRepository->getByName($input->name);

        if ($duplicated && $product->getName() !== $duplicated?->getName()) {
            throw new ProductDuplicatedException('Product name already exists.');
        }

        $product
            ->setName($input->name)
            ->setPrice(new Decimal($input->price))
            ->setUpdatedAt(Carbon::now());

        $updated = $this->productRepository->update($product);

        if (!$updated) {
            throw new ProductUpdateException('Product could not be updated.');
        }

        if (!empty($input->types)) {
            $this->productRepository->detachTypes($product->getId());

            $this->productRepository->attachTypes(array_map(static fn ($type) => [
                'product_id' => $product->getId(),
                'type_id'    => $type['id']
            ], $input->types));
        }

        return new UpdateProductOutputDto(
            id: $product->getId(),
            name: $product->getName(),
            price: $product->getPrice(),
            createdAt: $product->getCreatedAt(),
            updatedAt: $product->getUpdatedAt()
        );
    }
}
