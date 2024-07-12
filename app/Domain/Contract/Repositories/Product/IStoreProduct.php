<?php

namespace App\Domain\Contract\Repositories\Product;

use App\Domain\Entities\Product;

interface IStoreProduct
{
    public function store(Product $product): int;
}
