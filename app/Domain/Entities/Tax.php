<?php

namespace App\Domain\Entities;

use App\Domain\Exception\Tax\TaxInvalidPercentageException;
use Carbon\Carbon;

class Tax
{
    private float $percentage;

    /**
     * @throws TaxInvalidPercentageException
     */
    public function __construct(
        private string $name,
        float $percentage,
        readonly private ?int $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
    ) {
        $this->validatePercentage($percentage);

        $this->percentage = $percentage;
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

    /**
     * @throws TaxInvalidPercentageException
     */
    public function setPercentage(float $percentage): void
    {
        $this->validatePercentage($percentage);

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

    /**
     * @throws TaxInvalidPercentageException
     */
    private function validatePercentage(float $percentage): void
    {
        if ($percentage <= 0.0) {
            throw new TaxInvalidPercentageException('Tax percentage must be greater than 0.');
        }
    }
}
