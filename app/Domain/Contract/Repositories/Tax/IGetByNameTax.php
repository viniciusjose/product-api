<?php

namespace App\Domain\Contract\Repositories\Tax;

use App\Domain\Entities\Tax;

interface IGetByNameTax
{
    public function getByName(string $name): ?Tax;
}
