<?php

namespace App\Application\DTO\Product;

readonly class DestroyProductInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
