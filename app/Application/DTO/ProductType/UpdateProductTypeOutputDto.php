<?php

namespace App\Application\DTO\ProductType;

use App\Application\DTO\Arrayable;
use Carbon\Carbon;

class UpdateProductTypeOutputDto implements Arrayable
{
    public function __construct(
        public int $id,
        public string $name,
        public Carbon $createdAt,
        public Carbon $updatedAt,
        public ?string $description = null
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'created_at'  => $this->createdAt->toDateTimeString(),
            'updated_at'  => $this->updatedAt->toDateTimeString()
        ];
    }
}
