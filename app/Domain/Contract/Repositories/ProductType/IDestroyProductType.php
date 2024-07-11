<?php

namespace App\Domain\Contract\Repositories\ProductType;

use App\Domain\Entities\ProductType;

interface IDestroyProductType
{
    public function destroy(int $id): int;
}
