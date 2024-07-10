<?php

namespace App\Main\Factories\Application\UseCase\ProductType;

use App\Application\UseCase\ProductType\ListProductTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductTypeRepositoryFactory;

class ListProductTypeUseCaseFactory
{
    public static function make(): ListProductTypeUseCase
    {
        return new ListProductTypeUseCase(
            productTypeRepository: ProductTypeRepositoryFactory::make()
        );
    }
}
