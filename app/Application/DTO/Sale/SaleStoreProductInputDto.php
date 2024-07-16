<?php

namespace App\Application\DTO\Sale;

readonly class SaleStoreProductInputDto
{
    public function __construct(
        public string $id,
        public string $product_id,
        public int $quantity
    ) {
    }
}
