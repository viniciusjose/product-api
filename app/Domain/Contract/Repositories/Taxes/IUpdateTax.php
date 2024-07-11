<?php

namespace App\Domain\Contract\Repositories\Taxes;

use App\Domain\Entities\Tax;

interface IUpdateTax
{
    public function update(Tax $taxes): bool;
}
