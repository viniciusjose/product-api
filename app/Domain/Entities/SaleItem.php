<?php

namespace App\Domain\Entities;

use App\Domain\Exception\SaleItem\SaleItemInvalidFieldException;
use Carbon\Carbon;
use Decimal\Decimal;

class SaleItem
{
    private int $quantity;
    private Decimal $price;

    /**
     * @throws SaleItemInvalidFieldException
     */
    public function __construct(
        private readonly int $saleId,
        private int $productId,
        int $quantity,
        Decimal $price,
        private Decimal $taxesAmount,
        private Decimal $amount,
        private readonly ?int $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
    ) {
        $this->setQuantity($quantity);
        $this->setPrice($price);
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

    /**
     * @throws SaleItemInvalidFieldException
     */
    public function setQuantity(int $quantity): SaleItem
    {
        $this->validateQuantity($quantity);

        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice(): Decimal
    {
        return $this->price;
    }

    /**
     * @throws SaleItemInvalidFieldException
     */
    public function setPrice(Decimal $price): SaleItem
    {
        $this->validatePrice($price);

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

    /**
     * @throws SaleItemInvalidFieldException
     */
    private function validateQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new SaleItemInvalidFieldException('Quantity must be greater than 0');
        }
    }

    /**
     * @throws SaleItemInvalidFieldException
     */
    private function validatePrice(Decimal $price): void
    {
        if ($price->isNegative() || $price->isZero()) {
            throw new SaleItemInvalidFieldException('Price must be greater than 0');
        }
    }
}
