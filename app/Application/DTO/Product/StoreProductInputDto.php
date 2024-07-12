<?php

namespace App\Application\DTO\Product;

readonly class StoreProductInputDto
{
    public function __construct(
        public string $name,
        public float $price,
        public array $types = [],
    ) {
    }
}
