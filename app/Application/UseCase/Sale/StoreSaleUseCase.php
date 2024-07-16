<?php

namespace App\Application\UseCase\Sale;

use App\Application\DTO\Sale\StoreSaleInputDto;
use App\Domain\Contract\Repositories\Sale\IAttachTypes;
use App\Domain\Contract\Repositories\Sale\IGetByNameSale;
use App\Domain\Contract\Repositories\Sale\IStoreSale;
use App\Domain\Entities\Sale;
use App\Domain\Exception\Sale\SaleDuplicatedException;
use App\Domain\Exception\Sale\SaleInvalidPriceException;
use Decimal\Decimal;

readonly class StoreSaleUseCase
{
    public function __construct(
        protected IStoreSale $saleRepository
    ) {
    }

    /**
     * @throws SaleDuplicatedException
     * @throws SaleInvalidPriceException
     */
    public function handle(StoreSaleInputDto $input): void
    {
        $sale = new Sale(
            customer: $input->customer,
            email: $input->email,
            zipCode: $input->zipCode,
            address: $input->address,
            addressNumber: $input->addressNumber,
            description: $input->description
        );

        $this->saleRepository->store($sale);
    }
}
