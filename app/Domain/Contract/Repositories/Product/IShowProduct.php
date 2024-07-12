<?php

namespace App\Domain\Contract\Repositories\Product;

use App\Domain\Entities\Product;

interface IShowProduct
{
    public function show(int $id): ?Product;
}
