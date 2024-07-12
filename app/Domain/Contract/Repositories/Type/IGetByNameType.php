<?php

namespace App\Domain\Contract\Repositories\Type;

use App\Domain\Entities\Type;

interface IGetByNameType
{
    public function getByName(string $name): ?Type;
}
