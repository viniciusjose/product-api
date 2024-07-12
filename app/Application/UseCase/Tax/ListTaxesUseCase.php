<?php

namespace App\Application\UseCase\Tax;

use App\Domain\Contract\Repositories\Tax\IListTax;
use App\Domain\Queries\Tax\ListTaxesQuery;

readonly class ListTaxesUseCase
{
    public function __construct(
        protected IListTax $taxRepository
    ) {
    }

    public function handle(ListTaxesQuery $input): array
    {
        return $this->taxRepository->list($input);
    }
}
