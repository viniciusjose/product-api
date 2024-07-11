<?php

namespace App\Main\Factories\Application\UseCase\ProductType;

use App\Application\UseCase\ProductType\DestroyProductTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductTypeRepositoryFactory;

class DestroyProductTypeUseCaseFactory
{
    public static function make(): DestroyProductTypeUseCase
    {
        return new DestroyProductTypeUseCase(
            productTypeRepository: ProductTypeRepositoryFactory::make()
        );
    }
}
