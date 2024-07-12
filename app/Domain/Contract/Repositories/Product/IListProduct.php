<?php

namespace App\Domain\Contract\Repositories\Product;

use App\Domain\Queries\Product\ListProductQuery;

interface IListProduct
{
    public function list(ListProductQuery $query): array;
}
