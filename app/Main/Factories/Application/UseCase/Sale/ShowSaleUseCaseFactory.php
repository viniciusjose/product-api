<?php

namespace App\Main\Factories\Application\UseCase\Sale;

use App\Application\UseCase\Sale\ShowSaleUseCase;
use App\Main\Factories\Infra\Repositories\PDO\SaleRepositoryFactory;

class ShowSaleUseCaseFactory
{
    public static function make(): ShowSaleUseCase
    {
        return new ShowSaleUseCase(
            saleRepository: SaleRepositoryFactory::make()
        );
    }
}
