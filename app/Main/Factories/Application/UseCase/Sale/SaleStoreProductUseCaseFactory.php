<?php

namespace App\Main\Factories\Application\UseCase\Sale;

use App\Application\UseCase\Sale\SaleStoreProductUseCase;
use App\Main\Factories\Infra\Repositories\PDO\ProductRepositoryFactory;
use App\Main\Factories\Infra\Repositories\PDO\SaleItemRepositoryFactory;
use App\Main\Factories\Infra\Repositories\PDO\SaleRepositoryFactory;
use App\Main\Factories\Infra\Repositories\PDO\TaxRepositoryFactory;

class SaleStoreProductUseCaseFactory
{
    public static function make(): SaleStoreProductUseCase
    {
        return new SaleStoreProductUseCase(
            saleRepository: SaleRepositoryFactory::make(),
            saleItemRepository: SaleItemRepositoryFactory::make(),
            productRepository: ProductRepositoryFactory::make(),
            taxRepository: TaxRepositoryFactory::make()
        );
    }
}
