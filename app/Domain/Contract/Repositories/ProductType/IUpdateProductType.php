<?php

namespace App\Domain\Contract\Repositories\ProductType;

use App\Domain\Entities\ProductType;

interface IUpdateProductType
{
    public function update(ProductType $productType): bool;
}
