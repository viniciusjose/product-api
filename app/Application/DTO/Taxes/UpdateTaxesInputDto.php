<?php

namespace App\Application\DTO\Taxes;

readonly class UpdateTaxesInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public float $percentage
    ) {
    }
}
