<?php

namespace App\Application\DTO\Sale;

readonly class ShowSaleInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
