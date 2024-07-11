<?php

namespace App\Domain\Queries\Taxes;

class ListTaxesQuery
{
    public function __construct(
        public array $orderBy = ['name']
    ) {
    }
}
