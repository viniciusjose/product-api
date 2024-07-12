<?php

namespace App\Application\DTO\Tax;

readonly class StoreTaxesInputDto
{
    public function __construct(
        public string $name,
        public float $percentage
    ) {
    }
}
