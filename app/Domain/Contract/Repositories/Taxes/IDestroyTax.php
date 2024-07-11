<?php

namespace App\Domain\Contract\Repositories\Taxes;

use App\Domain\Entities\Tax;

interface IDestroyTax
{
    public function destroy(int $id): int;
}
