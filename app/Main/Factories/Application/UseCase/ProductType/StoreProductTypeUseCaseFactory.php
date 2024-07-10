<?php

namespace App\Main\Factories\Application\UseCase\ProductType;

use App\Application\UseCase\ProductType\StoreProductTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductTypeRepositoryFactory;

class StoreProductTypeUseCaseFactory
{
    public static function make(): StoreProductTypeUseCase
    {
        return new StoreProductTypeUseCase(
            productTypeRepository: ProductTypeRepositoryFactory::make()
        );
    }
}
