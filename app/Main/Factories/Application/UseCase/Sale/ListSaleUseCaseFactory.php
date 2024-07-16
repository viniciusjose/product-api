<?php

namespace App\Main\Factories\Application\UseCase\Sale;

use App\Application\UseCase\Sale\ListSaleUseCase;
use App\Main\Factories\Infra\Repositories\PDO\SaleRepositoryFactory;

class ListSaleUseCaseFactory
{
    public static function make(): ListSaleUseCase
    {
        return new ListSaleUseCase(
            saleRepository: SaleRepositoryFactory::make()
        );
    }
}
