<?php

namespace App\Main\Factories\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Infra\Database\Database;
use App\Infra\Repositories\PDO\ProductTypeRepository;

class ProductTypeRepositoryFactory
{
    public static function make(): IProductTypeRepository
    {
        return new ProductTypeRepository(
            db: Database::getInstance()
        );
    }
}
