<?php

namespace App\Application\DTO\Tax;

readonly class ShowTaxesInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
