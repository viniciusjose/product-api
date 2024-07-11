<?php

namespace App\Main\Factories\Application\UseCase\Taxes;

use App\Application\UseCase\Taxes\StoreTaxesUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class StoreTaxesUseCaseFactory
{
    public static function make(): StoreTaxesUseCase
    {
        return new StoreTaxesUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
