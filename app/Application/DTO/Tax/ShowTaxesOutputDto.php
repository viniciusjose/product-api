<?php

namespace App\Application\DTO\Tax;

use Carbon\Carbon;

readonly class ShowTaxesOutputDto
{
    public function __construct(
        public int $id,
        public string $name,
        public float $percentage,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'percentage' => $this->percentage,
            'created_at'  => $this->createdAt->toDateTimeString(),
            'updated_at'  => $this->updatedAt->toDateTimeString()
        ];
    }
}
