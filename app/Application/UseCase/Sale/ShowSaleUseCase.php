<?php

namespace App\Application\UseCase\Sale;

use App\Application\DTO\Sale\ShowSaleInputDto;
use App\Application\DTO\Sale\ShowSaleOutputDto;
use App\Domain\Contract\Repositories\Sale\IShowSale;
use App\Domain\Exception\Sale\SaleNotFoundException;

readonly class ShowSaleUseCase
{
    public function __construct(
        protected IShowSale $saleRepository
    ) {
    }

    /**
     * @throws SaleNotFoundException
     */
    public function handle(ShowSaleInputDto $input): ShowSaleOutputDto
    {
        $sale = $this->saleRepository->show($input->id);

        if ($sale === null) {
            throw new SaleNotFoundException('Sale not found.');
        }

        return new ShowSaleOutputDto(
            id: $sale->getId(),
            customer: $sale->getCustomer(),
            email: $sale->getEmail(),
            zipCode: $sale->getZipCode(),
            address: $sale->getAddress(),
            addressNumber: $sale->getAddressNumber(),
            description: $sale->getDescription(),
            amount: $sale->getAmount(),
            taxesAmount: $sale->getTaxesAmount(),
            totalAmount: $sale->getTotalAmount(),
            items: $sale->getItems(),
            createdAt: $sale->getCreatedAt(),
            updatedAt: $sale->getUpdatedAt()
        );
    }
}
