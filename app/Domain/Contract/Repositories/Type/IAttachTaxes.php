<?php

namespace App\Domain\Contract\Repositories\Type;

interface IAttachTaxes
{
    public function attachTaxes(array $taxes): void;
}
