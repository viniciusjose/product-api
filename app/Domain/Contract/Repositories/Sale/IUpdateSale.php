<?php

namespace App\Domain\Contract\Repositories\Sale;

use App\Domain\Entities\Sale;

interface IUpdateSale
{
    public function update(Sale $sale): bool;
}
