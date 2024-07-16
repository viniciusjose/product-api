<?php

namespace App\Domain\Entities;

use Carbon\Carbon;
use Decimal\Decimal;

class Sale
{
    private Decimal $totalAmount;
    private Decimal $taxesAmount;
    private Decimal $amount;

    public function __construct(
        private string $customer,
        private string $email,
        private string $zipCode,
        private string $address,
        private int $addressNumber,
        private ?int $id = null,
        private ?array $items = null,
        ?Decimal $amount = null,
        ?Decimal $taxesAmount = null,
        ?Decimal $totalAmount = null,
        private ?string $description = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null
    ) {
        $this->amount = $amount ?? new Decimal(0);
        $this->taxesAmount = $taxesAmount ?? new Decimal(0);
        $this->totalAmount = $totalAmount ?? new Decimal(0);
    }

    /**
     * @return string
     */
    public function getCustomer(): string
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     * @return Sale
     */
    public function setCustomer(string $customer): Sale
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return Sale
     */
    public function setZipCode(string $zipCode): Sale
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Sale
     */
    public function setAddress(string $address): Sale
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int
     */
    public function getAddressNumber(): int
    {
        return $this->addressNumber;
    }

    /**
     * @param int $address_number
     * @return Sale
     */
    public function setAddressNumber(int $addressNumber): Sale
    {
        $this->addressNumber = $addressNumber;
        return $this;
    }

    /**
     * @return Decimal
     */
    public function getAmount(): Decimal
    {
        return $this->amount;
    }

    /**
     * @param Decimal $amount
     * @return Sale
     */
    public function setAmount(Decimal $amount): Sale
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Decimal
     */
    public function getTaxesAmount(): Decimal
    {
        return $this->taxesAmount;
    }

    /**
     * @param Decimal $taxesAmount
     * @return Sale
     */
    public function setTaxesAmount(Decimal $taxesAmount): Sale
    {
        $this->taxesAmount = $taxesAmount;
        return $this;
    }

    /**
     * @return Decimal
     */
    public function getTotalAmount(): Decimal
    {
        return $this->totalAmount;
    }

    /**
     * @param Decimal $totalAmount
     * @return Sale
     */
    public function setTotalAmount(Decimal $totalAmount): Sale
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return Sale
     */
    public function setItems(array $items): Sale
    {
        $this->items = $items;
        return $this;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setDescription(?string $description = null): Sale
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setEmail(string $email): Sale
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
