<?php

namespace App\Domain\Entities;

use Carbon\Carbon;

class Type
{
    public function __construct(
        private string $name,
        readonly private ?int $id = null,
        private ?string $description = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
        private ?array $taxes = [],
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(Carbon $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTaxes(): ?array
    {
        return $this->taxes;
    }

    public function setTaxes(?array $taxes): void
    {
        $this->taxes = $taxes;
    }
}
