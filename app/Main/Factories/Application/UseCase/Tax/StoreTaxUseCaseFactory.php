<?php

namespace App\Main\Factories\Application\UseCase\Tax;

use App\Application\UseCase\Tax\StoreTaxUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class StoreTaxUseCaseFactory
{
    public static function make(): StoreTaxUseCase
    {
        return new StoreTaxUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
