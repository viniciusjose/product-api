<?php

namespace App\Domain\Contract\Repositories\Tax;

interface IGetTotalTaxByTypes
{
    public function getTotalTaxByTypes(array $types): array;
}
