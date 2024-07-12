<?php

namespace App\Domain\Contract\Repositories\Tax;

use App\Domain\Queries\Taxes\ListTaxesQuery;

interface IListTax
{
    public function list(ListTaxesQuery $query): array;
}
