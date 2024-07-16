<?php

namespace App\Application\DTO\Sale;

use Carbon\Carbon;
use Decimal\Decimal;

readonly class UpdateSaleInputDto
{
    public function __construct(
        public int $id,
        public string $customer,
        public string $email,
        public string $zipCode,
        public string $address,
        public int $addressNumber,
        public ?string $description
    ) {
    }
}
