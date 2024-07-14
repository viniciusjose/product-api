<?php

namespace App\Application\DTO\Type;

readonly class StoreTypeInputDto
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?array $taxes = []
    ) {
    }
}
