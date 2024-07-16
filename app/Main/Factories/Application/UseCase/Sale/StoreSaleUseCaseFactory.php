<?php

namespace App\Main\Factories\Application\UseCase\Sale;

use App\Application\UseCase\Sale\StoreSaleUseCase;
use App\Main\Factories\Infra\Repositories\PDO\SaleRepositoryFactory;

class StoreSaleUseCaseFactory
{
    public static function make(): StoreSaleUseCase
    {
        return new StoreSaleUseCase(
            saleRepository: SaleRepositoryFactory::make()
        );
    }
}
