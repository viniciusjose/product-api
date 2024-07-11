<?php

namespace App\Domain\Contract\Repositories\Taxes;

use App\Domain\Entities\Tax;

interface IShowTax
{
    public function show(int $id): ?Tax;
}
