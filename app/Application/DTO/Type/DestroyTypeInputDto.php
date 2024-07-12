<?php

namespace App\Application\DTO\Type;

readonly class DestroyTypeInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}
