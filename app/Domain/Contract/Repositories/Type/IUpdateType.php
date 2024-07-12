<?php

namespace App\Domain\Contract\Repositories\Type;

use App\Domain\Entities\Type;

interface IUpdateType
{
    public function update(Type $type): bool;
}
