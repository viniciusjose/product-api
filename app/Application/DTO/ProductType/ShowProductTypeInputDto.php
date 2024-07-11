<?php

namespace App\Application\DTO\ProductType;

readonly class ShowProductTypeInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
