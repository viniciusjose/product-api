<?php

namespace App\Domain\Contract\Repositories\Sale;

use App\Domain\Entities\Sale;

interface IStoreSale
{
    public function store(Sale $sale): int;
}
