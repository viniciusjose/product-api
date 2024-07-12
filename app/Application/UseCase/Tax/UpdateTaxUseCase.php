<?php

namespace App\Application\UseCase\Tax;

use App\Application\DTO\Tax\StoreTaxInputDto;
use App\Application\DTO\Tax\UpdateTaxInputDto;
use App\Application\DTO\Tax\UpdateTaxOutputDto;
use App\Domain\Contract\Repositories\Tax\IGetByNameTax;
use App\Domain\Contract\Repositories\Tax\IShowTax;
use App\Domain\Contract\Repositories\Tax\IStoreTax;
use App\Domain\Contract\Repositories\Tax\IUpdateTax;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\TaxDuplicatedException;
use App\Domain\Exception\Tax\TaxNotFoundException;
use App\Domain\Exception\Tax\TaxUpdateException;
use Carbon\Carbon;

readonly class UpdateTaxUseCase
{
    public function __construct(
        protected IUpdateTax|IGetByNameTax|IShowTax $taxRepository
    ) {
    }

    /**
     * @throws TaxDuplicatedException
     * @throws TaxNotFoundException
     * @throws TaxUpdateException
     */
    public function handle(UpdateTaxInputDto $input): UpdateTaxOutputDto
    {
        $Taxes = $this->taxRepository->show($input->id);

        if ($Taxes === null) {
            throw new TaxNotFoundException('Tax not found.');
        }

        $duplicated = $this->taxRepository->getByName($input->name);

        if ($duplicated && $Taxes->getName() !== $duplicated?->getName()) {
            throw new TaxDuplicatedException('Tax name already exists.');
        }

        $Taxes->setName($input->name);
        $Taxes->setPercentage($input->percentage);
        $Taxes->setUpdatedAt(Carbon::now());

        $updated = $this->taxRepository->update($Taxes);

        if (!$updated) {
            throw new TaxUpdateException('Tax could not be updated.');
        }

        return new UpdateTaxOutputDto(
            id: $Taxes->getId(),
            name: $Taxes->getName(),
            percentage: $Taxes->getPercentage(),
            createdAt: $Taxes->getCreatedAt(),
            updatedAt: $Taxes->getUpdatedAt()
        );
    }
}
