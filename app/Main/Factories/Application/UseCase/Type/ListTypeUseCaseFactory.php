<?php

namespace App\Main\Factories\Application\UseCase\Type;

use App\Application\UseCase\Type\ListTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TypeRepositoryFactory;

class ListTypeUseCaseFactory
{
    public static function make(): ListTypeUseCase
    {
        return new ListTypeUseCase(
            typeRepository: TypeRepositoryFactory::make()
        );
    }
}
