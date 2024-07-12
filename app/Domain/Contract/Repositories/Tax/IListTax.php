<?php

namespace App\Domain\Contract\Repositories\Tax;

use App\Domain\Queries\Tax\ListTaxesQuery;

interface IListTax
{
    public function list(ListTaxesQuery $query): array;
}
