<?php

namespace App\Application\DTO\Product;

use Carbon\Carbon;
use Decimal\Decimal;

readonly class ShowProductOutputDto
{
    public function __construct(
        public int $id,
        public string $name,
        public Decimal $price,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'price'           => $this->price->toFloat(),
            'created_at'      => $this->createdAt->toDateTimeString(),
            'updated_at'      => $this->updatedAt->toDateTimeString()
        ];
    }
}
