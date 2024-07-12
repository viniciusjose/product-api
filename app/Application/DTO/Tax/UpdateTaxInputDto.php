<?php

namespace App\Application\DTO\Tax;

readonly class UpdateTaxInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public float $percentage
    ) {
    }
}
