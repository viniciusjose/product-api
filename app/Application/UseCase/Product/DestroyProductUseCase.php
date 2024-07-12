<?php

namespace App\Application\UseCase\Product;

use App\Application\DTO\Product\DestroyProductInputDto;
use App\Domain\Contract\Repositories\Product\IDestroyProduct;
use App\Domain\Contract\Repositories\Product\IShowProduct;
use App\Domain\Exception\Product\ProductDestroyException;
use App\Domain\Exception\Product\ProductNotFoundException;

readonly class DestroyProductUseCase
{
    public function __construct(
        protected IDestroyProduct|IShowProduct $productRepository
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws ProductDestroyException
     */
    public function handle(DestroyProductInputDto $input): void
    {
        $product = $this->productRepository->show($input->id);

        if ($product === null) {
            throw new ProductNotFoundException('Product not found.');
        }

        $deleted = $this->productRepository->destroy($product->getId());

        if ($deleted === 0) {
            throw new ProductDestroyException('Product could not be deleted.');
        }
    }
}
