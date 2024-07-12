<?php

namespace App\Main\Factories\Application\UseCase\Type;

use App\Application\UseCase\Type\DestroyTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TypeRepositoryFactory;

class DestroyTypeUseCaseFactory
{
    public static function make(): DestroyTypeUseCase
    {
        return new DestroyTypeUseCase(
            typeRepository: TypeRepositoryFactory::make()
        );
    }
}
