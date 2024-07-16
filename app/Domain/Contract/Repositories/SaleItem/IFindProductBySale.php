<?php

namespace App\Domain\Contract\Repositories\SaleItem;

use App\Domain\Entities\SaleItem;

interface IFindProductBySale
{
    public function findProductBySale(int $saleId, int $productId): ?SaleItem;
}
