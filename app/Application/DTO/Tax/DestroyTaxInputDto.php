<?php

namespace App\Application\DTO\Tax;

readonly class DestroyTaxInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
