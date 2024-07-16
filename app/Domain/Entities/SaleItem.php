<?php

namespace App\Domain\Entities;

use Carbon\Carbon;
use Decimal\Decimal;

class SaleItem
{
    public function __construct(
        private readonly int $saleId,
        private int $productId,
        private int $quantity,
        private Decimal $price,
        private Decimal $taxesAmount,
        private Decimal $amount,
        private readonly ?int $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
    ) {
    }

    public function getSaleId(): int
    {
        return $this->saleId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): SaleItem
    {
        $this->productId = $productId;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): SaleItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice(): Decimal
    {
        return $this->price;
    }

    public function setPrice(Decimal $price): SaleItem
    {
        $this->price = $price;
        return $this;
    }

    public function getTaxesAmount(): Decimal
    {
        return $this->taxesAmount;
    }

    public function setTaxesAmount(Decimal $taxesAmount): SaleItem
    {
        $this->taxesAmount = $taxesAmount;
        return $this;
    }

    public function getAmount(): Decimal
    {
        return $this->amount;
    }

    public function setAmount(Decimal $amount): SaleItem
    {
        $this->amount = $amount;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCreatedAt(?Carbon $createdAt): SaleItem
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): SaleItem
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }
}
