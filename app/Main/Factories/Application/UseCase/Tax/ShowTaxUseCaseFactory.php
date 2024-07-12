<?php

namespace App\Main\Factories\Application\UseCase\Tax;

use App\Application\UseCase\Tax\ShowTaxUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class ShowTaxUseCaseFactory
{
    public static function make(): ShowTaxUseCase
    {
        return new ShowTaxUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
