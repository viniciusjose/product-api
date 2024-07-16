<?php

namespace App\Domain\Contract\Repositories\Tax;

interface ITaxRepository extends
    IListTax,
    IShowTax,
    IStoreTax,
    IUpdateTax,
    IDestroyTax,
    IGetByNameTax,
    IGetTotalTaxByTypes
{
}
