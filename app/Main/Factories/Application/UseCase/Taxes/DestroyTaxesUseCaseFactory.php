<?php

namespace App\Main\Factories\Application\UseCase\Taxes;

use App\Application\UseCase\Taxes\DestroyTaxesUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class DestroyTaxesUseCaseFactory
{
    public static function make(): DestroyTaxesUseCase
    {
        return new DestroyTaxesUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
