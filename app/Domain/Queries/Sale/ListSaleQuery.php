<?php

namespace App\Domain\Queries\Sale;

class ListSaleQuery
{
    public function __construct(
        public array $orderBy = ['name']
    ) {
    }
}
