<?php

namespace App\Domain\Contract\Repositories\ProductType;

use App\Domain\Entities\ProductType;

interface IStoreProductType
{
    public function store(ProductType $productType): int;
}