<?php

namespace App\Main\Factories\Application\UseCase\Taxes;

use App\Application\UseCase\Taxes\ShowTaxesUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class ShowTaxesUseCaseFactory
{
    public static function make(): ShowTaxesUseCase
    {
        return new ShowTaxesUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
