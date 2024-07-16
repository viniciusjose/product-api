<?php

namespace App\Application\UseCase\Sale;

use App\Application\DTO\Sale\UpdateSaleInputDto;
use App\Application\DTO\Sale\UpdateSaleOutputDto;
use App\Domain\Contract\Repositories\Sale\IShowSale;
use App\Domain\Contract\Repositories\Sale\IUpdateSale;
use App\Domain\Exception\Sale\SaleNotFoundException;
use App\Domain\Exception\Sale\SaleUpdateException;
use Carbon\Carbon;
use JsonException;

readonly class UpdateSaleUseCase
{
    public function __construct(
        protected IShowSale|IUpdateSale $saleRepository
    ) {
    }

    /**
     * @throws SaleNotFoundException
     * @throws JsonException
     * @throws SaleUpdateException
     */
    public function handle(UpdateSaleInputDto $input): UpdateSaleOutputDto
    {
        $sale = $this->saleRepository->show($input->id);

        if ($sale === null) {
            throw new SaleNotFoundException('Sale not found.');
        }

        $sale
            ->setCustomer($input->customer)
            ->setEmail($input->email)
            ->setZipCode($input->zipCode)
            ->setAddress($input->address)
            ->setAddressNumber($input->addressNumber)
            ->setDescription($input->description)
            ->setUpdatedAt(Carbon::now());

        $updated = $this->saleRepository->update($sale);

        if (!$updated) {
            throw new SaleUpdateException('Sale could not be updated.');
        }

        return new UpdateSaleOutputDto(
            id: $sale->getId(),
            customer: $sale->getCustomer(),
            email: $sale->getEmail(),
            zipCode: $sale->getZipCode(),
            address: $sale->getAddress(),
            addressNumber: $sale->getAddressNumber(),
            description: $sale->getDescription()
        );
    }
}
