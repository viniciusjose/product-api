<?php

namespace App\Application\DTO\Sale;

readonly class StoreSaleInputDto
{
    public function __construct(
        public string $customer,
        public string $email,
        public string $zipCode,
        public string $address,
        public string $addressNumber,
        public ?string $description = null
    ) {
    }
}
