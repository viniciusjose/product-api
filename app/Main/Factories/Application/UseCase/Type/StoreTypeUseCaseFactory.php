<?php

namespace App\Main\Factories\Application\UseCase\Type;

use App\Application\UseCase\Type\StoreTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TypeRepositoryFactory;

class StoreTypeUseCaseFactory
{
    public static function make(): StoreTypeUseCase
    {
        return new StoreTypeUseCase(
            typeRepository: TypeRepositoryFactory::make()
        );
    }
}
