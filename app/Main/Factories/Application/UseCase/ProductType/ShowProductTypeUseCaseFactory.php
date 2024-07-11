<?php

namespace App\Main\Factories\Application\UseCase\ProductType;

use App\Application\UseCase\ProductType\ShowProductTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductTypeRepositoryFactory;

class ShowProductTypeUseCaseFactory
{
    public static function make(): ShowProductTypeUseCase
    {
        return new ShowProductTypeUseCase(
            productTypeRepository: ProductTypeRepositoryFactory::make()
        );
    }
}
