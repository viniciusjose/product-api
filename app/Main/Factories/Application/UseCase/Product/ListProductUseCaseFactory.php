<?php

namespace App\Main\Factories\Application\UseCase\Product;

use App\Application\UseCase\Product\ListProductUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductRepositoryFactory;

class ListProductUseCaseFactory
{
    public static function make(): ListProductUseCase
    {
        return new ListProductUseCase(
            productRepository: ProductRepositoryFactory::make()
        );
    }
}
