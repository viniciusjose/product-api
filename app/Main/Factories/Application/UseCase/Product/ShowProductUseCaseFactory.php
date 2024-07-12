<?php

namespace App\Main\Factories\Application\UseCase\Product;

use App\Application\UseCase\Product\ShowProductUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductRepositoryFactory;

class ShowProductUseCaseFactory
{
    public static function make(): ShowProductUseCase
    {
        return new ShowProductUseCase(
            productRepository: ProductRepositoryFactory::make()
        );
    }
}
