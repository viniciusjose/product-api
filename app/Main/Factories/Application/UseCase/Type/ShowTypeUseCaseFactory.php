<?php

namespace App\Main\Factories\Application\UseCase\Type;

use App\Application\UseCase\Type\ShowTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TypeRepositoryFactory;

class ShowTypeUseCaseFactory
{
    public static function make(): ShowTypeUseCase
    {
        return new ShowTypeUseCase(
            typeRepository: TypeRepositoryFactory::make()
        );
    }
}
