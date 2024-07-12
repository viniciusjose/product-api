<?php

namespace App\Domain\Contract\Repositories\Tax;

use App\Domain\Entities\Tax;

interface IStoreTax
{
    public function store(Tax $taxes): int;
}
