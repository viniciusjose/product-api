<?php

namespace App\Application\DTO\Tax;

readonly class DestroyTaxesInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
