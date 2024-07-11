<?php

namespace App\Domain\Contract\Repositories\Taxes;

use App\Domain\Entities\Tax;

interface IGetByNameTax
{
    public function getByName(string $name): ?Tax;
}
