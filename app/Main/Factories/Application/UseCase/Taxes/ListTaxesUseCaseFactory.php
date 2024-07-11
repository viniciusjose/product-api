<?php

namespace App\Main\Factories\Application\UseCase\Taxes;

use App\Application\UseCase\Taxes\ListTaxesUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class ListTaxesUseCaseFactory
{
    public static function make(): ListTaxesUseCase
    {
        return new ListTaxesUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
