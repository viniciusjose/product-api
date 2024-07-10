<?php

namespace App\Application\DTO\ProductType;

readonly class StoreProductTypeInputDto
{
    public function __construct(
        public string $name,
        public ?string $description
    ) {
    }
}
