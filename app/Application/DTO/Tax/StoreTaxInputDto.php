<?php

namespace App\Application\DTO\Tax;

readonly class StoreTaxInputDto
{
    public function __construct(
        public string $name,
        public float $percentage
    ) {
    }
}
