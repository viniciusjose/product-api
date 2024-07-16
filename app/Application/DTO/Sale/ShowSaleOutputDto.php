<?php

namespace App\Application\DTO\Sale;

use App\Application\DTO\Arrayable;
use Carbon\Carbon;
use Decimal\Decimal;

readonly class ShowSaleOutputDto implements Arrayable
{
    public function __construct(
        public int $id,
        public string $customer,
        public string $email,
        public string $zipCode,
        public string $address,
        public int $addressNumber,
        public ?string $description,
        public Decimal $amount,
        public Decimal $taxesAmount,
        public Decimal $totalAmount,
        public array $items,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'                 => $this->id,
            'customer'           => $this->customer,
            'email'              => $this->email,
            'zip_code'           => $this->zipCode,
            'address'            => $this->address,
            'address_number'      => $this->addressNumber,
            'description' => $this->description,
            'amount'             => $this->amount->toFloat(),
            'taxesAmount'        => $this->taxesAmount->toFloat(),
            'totalAmount'        => $this->totalAmount->toFloat(),
            'items'              => $this->items,
            'created_at'         => $this->createdAt->toDateTimeString(),
            'updated_at'         => $this->updatedAt->toDateTimeString()
        ];
    }
}
