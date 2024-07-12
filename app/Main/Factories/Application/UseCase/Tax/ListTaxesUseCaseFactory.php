<?php

namespace App\Main\Factories\Application\UseCase\Tax;

use App\Application\UseCase\Tax\ListTaxesUseCase;
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
