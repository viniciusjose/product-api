<?php

namespace App\Application\DTO\Product;

readonly class UpdateProductInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $price,
        public array $types,
    ) {
    }
}
