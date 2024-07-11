<?php

namespace App\Application\DTO\ProductType;

readonly class DestroyProductTypeInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
