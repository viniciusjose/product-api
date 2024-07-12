<?php

namespace App\Main\Factories\Application\UseCase\Product;

use App\Application\UseCase\Product\DestroyProductUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductRepositoryFactory;

class DestroyProductUseCaseFactory
{
    public static function make(): DestroyProductUseCase
    {
        return new DestroyProductUseCase(
            productRepository: ProductRepositoryFactory::make()
        );
    }
}
