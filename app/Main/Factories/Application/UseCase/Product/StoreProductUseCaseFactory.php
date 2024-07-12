<?php

namespace App\Main\Factories\Application\UseCase\Product;

use App\Application\UseCase\Product\StoreProductUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductRepositoryFactory;

class StoreProductUseCaseFactory
{
    public static function make(): StoreProductUseCase
    {
        return new StoreProductUseCase(
            productRepository: ProductRepositoryFactory::make()
        );
    }
}
