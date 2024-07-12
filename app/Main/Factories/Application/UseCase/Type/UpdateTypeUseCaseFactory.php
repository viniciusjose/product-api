<?php

namespace App\Main\Factories\Application\UseCase\Type;

use App\Application\UseCase\Type\UpdateTypeUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TypeRepositoryFactory;

class UpdateTypeUseCaseFactory
{
    public static function make(): UpdateTypeUseCase
    {
        return new UpdateTypeUseCase(
            TypeRepository: TypeRepositoryFactory::make()
        );
    }
}
