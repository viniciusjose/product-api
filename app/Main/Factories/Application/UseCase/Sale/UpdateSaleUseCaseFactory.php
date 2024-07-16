<?php

namespace App\Main\Factories\Application\UseCase\Sale;

use App\Application\UseCase\Sale\UpdateSaleUseCase;
use App\Main\Factories\Infra\Repositories\PDO\SaleRepositoryFactory;

class UpdateSaleUseCaseFactory
{
    public static function make(): UpdateSaleUseCase
    {
        return new UpdateSaleUseCase(
            saleRepository: SaleRepositoryFactory::make()
        );
    }
}
