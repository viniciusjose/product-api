<?php

namespace App\Main\Factories\Application\UseCase\Sale;

use App\Application\UseCase\Sale\DestroySaleUseCase;
use App\Main\Factories\Infra\Repositories\PDO\SaleRepositoryFactory;

class DestroySaleUseCaseFactory
{
    public static function make(): DestroySaleUseCase
    {
        return new DestroySaleUseCase(
            saleRepository: SaleRepositoryFactory::make()
        );
    }
}
