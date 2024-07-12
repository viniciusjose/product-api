<?php

namespace App\Domain\Queries\Product;

class ListProductQuery
{
    public function __construct(
        public array $orderBy = ['name']
    ) {
    }
}
