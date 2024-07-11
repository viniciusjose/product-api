<?php

namespace App\Application\DTO\Taxes;

readonly class ShowTaxesInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
