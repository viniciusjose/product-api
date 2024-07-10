<?php

namespace App\Application\DTO\ProductType;

class UpdateProductTypeInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description = null
    ) {
    }
}
