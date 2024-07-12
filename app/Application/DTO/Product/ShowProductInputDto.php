<?php

namespace App\Application\DTO\Product;

readonly class ShowProductInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
