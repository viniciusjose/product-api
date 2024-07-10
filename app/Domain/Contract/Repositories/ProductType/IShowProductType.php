<?php

namespace App\Domain\Contract\Repositories\ProductType;

use App\Domain\Entities\ProductType;

interface IShowProductType
{
    public function show(int $id): ?ProductType;
}
