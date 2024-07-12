<?php

namespace App\Main\Factories\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Infra\Database\Database;
use App\Infra\Repositories\PDO\ProductRepository;

class ProductRepositoryFactory
{
    public static function make(): IProductRepository
    {
        return new ProductRepository(
            db: Database::getInstance()
        );
    }
}
