<?php

namespace App\Main\Factories\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Infra\Database\Database;
use App\Infra\Repositories\PDO\TaxRepository;

class TaxRepositoryFactory
{
    public static function make(): ITaxRepository
    {
        return new TaxRepository(
            db: Database::getInstance()
        );
    }
}
