<?php

namespace App\Application\UseCase\Taxes;

use App\Application\DTO\Taxes\StoreTaxesInputDto;
use App\Domain\Contract\Repositories\Taxes\IGetByNameTax;
use App\Domain\Contract\Repositories\Taxes\IStoreTax;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Taxes\TaxesDuplicatedException;

readonly class StoreTaxesUseCase
{
    public function __construct(
        protected IStoreTax|IGetByNameTax $taxRepository
    ) {
    }

    /**
     * @throws TaxesDuplicatedException
     */
    public function handle(StoreTaxesInputDto $input): void
    {
        $Taxes = $this->taxRepository->getByName($input->name);

        if ($Taxes) {
            throw new TaxesDuplicatedException('Tax already exists.');
        }

        $Taxes = new Tax(
            name: $input->name,
            percentage: $input->percentage
        );

        $this->taxRepository->store($Taxes);
    }
}
