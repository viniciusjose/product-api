<?php

namespace App\Application\DTO\Taxes;

readonly class StoreTaxesInputDto
{
    public function __construct(
        public string $name,
        public float $percentage
    ) {
    }
}
