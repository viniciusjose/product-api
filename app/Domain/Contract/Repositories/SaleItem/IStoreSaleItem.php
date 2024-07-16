<?php

namespace App\Domain\Contract\Repositories\SaleItem;

use App\Domain\Entities\SaleItem;

interface IStoreSaleItem
{
    public function store(SaleItem $saleItem): int;
}
