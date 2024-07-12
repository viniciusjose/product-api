<?php

namespace App\Domain\Contract\Repositories\Product;

use App\Domain\Entities\Product;

interface IUpdateProduct
{
    public function update(Product $product): bool;
}
