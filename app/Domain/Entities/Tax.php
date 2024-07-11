<?php

namespace App\Domain\Entities;

use Carbon\Carbon;

class Tax
{
    public function __construct(
        private string $name,
        private float $percentage,
        readonly private ?int $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): void
    {
        $this->percentage = $percentage;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?Carbon $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
