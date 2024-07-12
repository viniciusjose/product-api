<?php

namespace App\Application\UseCase\Product;

use App\Application\DTO\Product\ShowProductInputDto;
use App\Application\DTO\Product\ShowProductOutputDto;
use App\Domain\Contract\Repositories\Product\IShowProduct;
use App\Domain\Exception\Product\ProductNotFoundException;

readonly class ShowProductUseCase
{
    public function __construct(
        protected IShowProduct $productRepository
    ) {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function handle(ShowProductInputDto $input): ShowProductOutputDto
    {
        $product = $this->productRepository->show($input->id);

        if ($product === null) {
            throw new ProductNotFoundException('Product not found.');
        }

        return new ShowProductOutputDto(
            id: $product->getId(),
            name: $product->getName(),
            price: $product->getPrice(),
            createdAt: $product->getCreatedAt(),
            updatedAt: $product->getUpdatedAt()
        );
    }
}
