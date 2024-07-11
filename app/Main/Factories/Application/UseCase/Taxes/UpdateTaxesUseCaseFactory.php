<?php

namespace App\Main\Factories\Application\UseCase\Taxes;

use App\Application\UseCase\Taxes\UpdateTaxesUseCase;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class UpdateTaxesUseCaseFactory
{
    public static function make(): UpdateTaxesUseCase
    {
        return new UpdateTaxesUseCase(
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
