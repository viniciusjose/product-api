<?php

namespace App\Main\Factories\Application\UseCase\Tax;

use App\Application\UseCase\Tax\UpdateTaxUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class UpdateTaxUseCaseFactory
{
    public static function make(): UpdateTaxUseCase
    {
        return new UpdateTaxUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
