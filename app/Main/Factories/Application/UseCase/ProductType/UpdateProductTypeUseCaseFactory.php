<?php

namespace App\Main\Factories\Application\UseCase\ProductType;

use App\Application\UseCase\ProductType\StoreProductTypeUseCase;
use App\Application\UseCase\ProductType\UpdateProductTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductTypeRepositoryFactory;

class UpdateProductTypeUseCaseFactory
{
    public static function make(): UpdateProductTypeUseCase
    {
        return new UpdateProductTypeUseCase(
            productTypeRepository: ProductTypeRepositoryFactory::make()
        );
    }
}
