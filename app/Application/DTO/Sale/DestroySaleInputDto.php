<?php

namespace App\Application\DTO\Sale;

readonly class DestroySaleInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
