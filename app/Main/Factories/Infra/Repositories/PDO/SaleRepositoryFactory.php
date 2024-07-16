<?php

namespace App\Main\Factories\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Infra\Database\Database;
use App\Infra\Repositories\PDO\SaleRepository;

class SaleRepositoryFactory
{
    public static function make(): ISaleRepository
    {
        return new SaleRepository(
            db: Database::getInstance()
        );
    }
}
