<?php

namespace App\Main\Factories\Application\UseCase\Product;

use App\Application\UseCase\Product\UpdateProductUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductRepositoryFactory;

class UpdateProductUseCaseFactory
{
    public static function make(): UpdateProductUseCase
    {
        return new UpdateProductUseCase(
            productRepository: ProductRepositoryFactory::make()
        );
    }
}
