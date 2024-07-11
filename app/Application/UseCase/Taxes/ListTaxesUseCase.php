<?php

namespace App\Application\UseCase\Taxes;

use App\Domain\Contract\Repositories\Taxes\IListTax;
use App\Domain\Queries\Taxes\ListTaxesQuery;

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
