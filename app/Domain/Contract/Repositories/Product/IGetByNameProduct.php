<?php

namespace App\Domain\Contract\Repositories\Product;

use App\Domain\Entities\Product;

interface IGetByNameProduct
{
    public function getByName(string $name): ?Product;
}
