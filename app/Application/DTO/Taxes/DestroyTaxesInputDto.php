<?php

namespace App\Application\DTO\Taxes;

readonly class DestroyTaxesInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
