<?php

namespace App\Domain\Contract\Repositories\SaleItem;

interface ISaleItemRepository extends
    IStoreSaleItem,
    IFindProductBySale
{
}
