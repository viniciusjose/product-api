<?php

namespace App\Main\Factories\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Infra\Database\Database;
use App\Infra\Repositories\PDO\TypeRepository;

class TypeRepositoryFactory
{
    public static function make(): ITypeRepository
    {
        return new TypeRepository(
            db: Database::getInstance()
        );
    }
}
