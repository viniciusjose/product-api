<?php

namespace App\Domain\Contract\Repositories\Taxes;

interface ITaxRepository extends
    IListTax,
    IShowTax,
    IStoreTax,
    IUpdateTax,
    IDestroyTax,
    IGetByNameTax
{
}
