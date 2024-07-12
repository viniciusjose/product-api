<?php

namespace App\Main\Factories\Application\UseCase\Tax;

use App\Application\UseCase\Tax\DestroyTaxUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class DestroyTaxUseCaseFactory
{
    public static function make(): DestroyTaxUseCase
    {
        return new DestroyTaxUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
