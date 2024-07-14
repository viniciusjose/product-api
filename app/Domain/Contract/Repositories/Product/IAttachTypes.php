<?php

namespace App\Domain\Contract\Repositories\Product;

interface IAttachTypes
{
    public function attachTypes(array $types): void;
}
