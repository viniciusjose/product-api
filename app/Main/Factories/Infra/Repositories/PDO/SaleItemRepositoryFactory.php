<?php

namespace App\Main\Factories\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Contract\Repositories\SaleItem\ISaleItemRepository;
use App\Infra\Database\Database;
use App\Infra\Repositories\PDO\SaleItemRepository;
use App\Infra\Repositories\PDO\SaleRepository;

class SaleItemRepositoryFactory
{
    public static function make(): ISaleItemRepository
    {
        return new SaleItemRepository(
            db: Database::getInstance()
        );
    }
}
