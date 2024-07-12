<?php

namespace App\Domain\Contract\Repositories\Tax;

use App\Domain\Entities\Tax;

interface IUpdateTax
{
    public function update(Tax $taxes): bool;
}
