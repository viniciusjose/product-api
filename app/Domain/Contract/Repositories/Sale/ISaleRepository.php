<?php

namespace App\Domain\Contract\Repositories\Sale;

interface ISaleRepository extends
    IListSale,
    IShowSale,
    IStoreSale,
    IUpdateSale,
    IDestroySale
{
}
