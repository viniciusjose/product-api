<?php

namespace App\Domain\Contract\Repositories\Type;

use App\Domain\Entities\Type;

interface IStoreType
{
    public function store(Type $type): int;
}
