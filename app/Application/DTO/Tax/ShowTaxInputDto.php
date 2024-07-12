<?php

namespace App\Application\DTO\Tax;

readonly class ShowTaxInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
