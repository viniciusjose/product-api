<?php

namespace App\Domain\Contract\Repositories\Sale;

use App\Domain\Entities\Sale;

interface IShowSale
{
    public function show(int $id): ?Sale;
}
