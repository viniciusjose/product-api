<?php

namespace App\Domain\Queries\Type;

class ListTypeQuery
{
    public function __construct(
        public array $orderBy = ['name']
    ) {
    }
}
