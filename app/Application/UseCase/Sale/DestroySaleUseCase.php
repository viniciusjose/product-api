<?php

namespace App\Application\UseCase\Sale;

use App\Application\DTO\Sale\DestroySaleInputDto;
use App\Domain\Contract\Repositories\Sale\IDestroySale;
use App\Domain\Contract\Repositories\Sale\IShowSale;
use App\Domain\Exception\Sale\SaleDestroyException;
use App\Domain\Exception\Sale\SaleNotFoundException;

readonly class DestroySaleUseCase
{
    public function __construct(
        protected IDestroySale|IShowSale $saleRepository
    ) {
    }

    /**
     * @throws SaleNotFoundException
     * @throws SaleDestroyException
     */
    public function handle(DestroySaleInputDto $input): void
    {
        $sale = $this->saleRepository->show($input->id);

        if ($sale === null) {
            throw new SaleNotFoundException('Sale not found.');
        }

        $deleted = $this->saleRepository->destroy($sale->getId());

        if ($deleted === 0) {
            throw new SaleDestroyException('Sale could not be deleted.');
        }
    }
}
