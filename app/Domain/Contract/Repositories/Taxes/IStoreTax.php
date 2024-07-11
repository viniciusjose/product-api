<?php

namespace App\Domain\Contract\Repositories\Taxes;

use App\Domain\Entities\Tax;

interface IStoreTax
{
    public function store(Tax $taxes): int;
}
