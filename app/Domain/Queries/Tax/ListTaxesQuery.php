<?php

namespace App\Domain\Queries\Tax;

class ListTaxesQuery
{
    public function __construct(
        public array $orderBy = ['name']
    ) {
    }
}
