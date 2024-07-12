<?php

namespace App\Domain\Contract\Repositories\Type;

use App\Domain\Entities\Type;

interface IShowType
{
    public function show(int $id): ?Type;
}
