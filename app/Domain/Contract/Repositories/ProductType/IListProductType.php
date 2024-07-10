<?php

namespace App\Domain\Contract\Repositories\ProductType;

use App\Domain\Queries\ProductType\ListProductTypeQuery;

interface IListProductType
{
    public function list(ListProductTypeQuery $query): array;
}
