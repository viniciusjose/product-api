<?php

namespace App\Domain\Contract\Repositories\Taxes;

use App\Domain\Queries\Taxes\ListTaxesQuery;

interface IListTax
{
    public function list(ListTaxesQuery $query): array;
}
