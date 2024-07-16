<?php

namespace App\Domain\Contract\Repositories\Sale;

use App\Domain\Queries\Sale\ListSaleQuery;

interface IListSale
{
    public function list(ListSaleQuery $query): array;
}
