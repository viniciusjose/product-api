<?php

namespace App\Application\UseCase\Tax;

use App\Application\DTO\Tax\StoreTaxInputDto;
use App\Domain\Contract\Repositories\Tax\IGetByNameTax;
use App\Domain\Contract\Repositories\Tax\IStoreTax;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\TaxDuplicatedException;

readonly class StoreTaxUseCase
{
    public function __construct(
        protected IStoreTax|IGetByNameTax $taxRepository
    ) {
    }

    /**
     * @throws TaxDuplicatedException
     */
    public function handle(StoreTaxInputDto $input): void
    {
        $Taxes = $this->taxRepository->getByName($input->name);

        if ($Taxes) {
            throw new TaxDuplicatedException('Tax already exists.');
        }

        $Taxes = new Tax(
            name: $input->name,
            percentage: $input->percentage / 100
        );

        $this->taxRepository->store($Taxes);
    }
}
