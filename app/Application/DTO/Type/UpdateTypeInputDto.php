<?php

namespace App\Application\DTO\Type;

readonly class UpdateTypeInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description = null,
        public ?array $taxes = []
    ) {
    }
}
