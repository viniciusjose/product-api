<?php

namespace App\Application\DTO\Sale;

use App\Application\DTO\Arrayable;

readonly class UpdateSaleOutputDto implements Arrayable
{
    public function __construct(
        public int $id,
        public string $customer,
        public string $email,
        public string $zipCode,
        public string $address,
        public int $addressNumber,
        public ?string $description,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'customer'       => $this->customer,
            'email'          => $this->email,
            'zip_code'       => $this->zipCode,
            'address'        => $this->address,
            'address_number' => $this->addressNumber,
            'description'    => $this->description
        ];
    }
}
