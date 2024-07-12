<?php

namespace App\Application\DTO\Type;

readonly class ShowTypeInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
