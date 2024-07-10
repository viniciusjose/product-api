<?php

namespace App\Domain\Contract\Repositories\ProductType;

use App\Domain\Entities\ProductType;

interface IGetByNameProductType
{
    public function getByName(string $name): ?ProductType;
}
