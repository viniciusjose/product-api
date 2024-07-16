<?php

namespace App\Application\UseCase\Sale;

use App\Domain\Contract\Repositories\Sale\IListSale;
use App\Domain\Queries\Sale\ListSaleQuery;

readonly class ListSaleUseCase
{
    public function __construct(
        protected IListSale $saleRepository
    ) {
    }

    public function handle(ListSaleQuery $input): array
    {
        return $this->saleRepository->list($input);
    }
}
