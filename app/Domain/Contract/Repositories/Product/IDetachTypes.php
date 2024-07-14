<?php

namespace App\Domain\Contract\Repositories\Product;

interface IDetachTypes
{
    public function detachTypes(int $id): int;
}
