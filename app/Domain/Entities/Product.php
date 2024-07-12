<?php

namespace App\Domain\Entities;

use App\Domain\Exception\Product\ProductInvalidPriceException;
use Carbon\Carbon;
use Decimal\Decimal;

class Product
{
    private Decimal $price;

    /**
     * @throws ProductInvalidPriceException
     */
    public function __construct(
        private string $name,
        Decimal $price,
        private readonly ?string $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null
    ) {
        $this->validatePrice($price);

        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(Carbon $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getPrice(): Decimal
    {
        return $this->price;
    }

    /**
     * @throws ProductInvalidPriceException
     */
    public function setPrice(Decimal $price): self
    {
        $this->validatePrice($price);

        $this->price = $price;
        return $this;
    }

    /**
     * @throws ProductInvalidPriceException
     */
    private function validatePrice(Decimal $price): void
    {
        if ($price <= 0.0) {
            throw new ProductInvalidPriceException('Tax percentage must be greater than 0.');
        }
    }
}
