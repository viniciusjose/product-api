<?php

namespace App\Domain\Contract\Repositories\Type;

interface IDetachTaxes
{
    public function detachTaxes(int $id): int;
}
