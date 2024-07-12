<?php

namespace App\Domain\Queries\ProductType;

class ListProductTypeQuery
{
    public function __construct(
        public array $orderBy = ['name']
    ) {
    }
}
