<?php

namespace App\Domain\Contract\Repositories\Tax;

use App\Domain\Entities\Tax;

interface IDestroyTax
{
    public function destroy(int $id): int;
}
