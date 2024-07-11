<?php

namespace App\Application\UseCase\Taxes;

use App\Application\DTO\Taxes\StoreTaxesInputDto;
use App\Application\DTO\Taxes\UpdateTaxesInputDto;
use App\Application\DTO\Taxes\UpdateTaxesOutputDto;
use App\Domain\Contract\Repositories\Taxes\IGetByNameTax;
use App\Domain\Contract\Repositories\Taxes\IShowTax;
use App\Domain\Contract\Repositories\Taxes\IStoreTax;
use App\Domain\Contract\Repositories\Taxes\IUpdateTax;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Taxes\TaxesDuplicatedException;
use App\Domain\Exception\Taxes\TaxesNotFoundException;
use App\Domain\Exception\Taxes\TaxesUpdateException;
use Carbon\Carbon;

readonly class UpdateTaxesUseCase
{
    public function __construct(
        protected IUpdateTax|IGetByNameTax|IShowTax $taxRepository
    ) {
    }

    /**
     * @throws TaxesDuplicatedException
     * @throws TaxesNotFoundException
     * @throws TaxesUpdateException
     */
    public function handle(UpdateTaxesInputDto $input): UpdateTaxesOutputDto
    {
        $Taxes = $this->taxRepository->show($input->id);

        if ($Taxes === null) {
            throw new TaxesNotFoundException('Tax not found.');
        }

        $duplicated = $this->taxRepository->getByName($input->name);

        if ($duplicated && $Taxes->getName() !== $duplicated?->getName()) {
            throw new TaxesDuplicatedException('Tax name already exists.');
        }

        $Taxes->setName($input->name);
        $Taxes->setPercentage($input->percentage);
        $Taxes->setUpdatedAt(Carbon::now());

        $updated = $this->taxRepository->update($Taxes);

        if (!$updated) {
            throw new TaxesUpdateException('Tax could not be updated.');
        }

        return new UpdateTaxesOutputDto(
            id: $Taxes->getId(),
            name: $Taxes->getName(),
            percentage: $Taxes->getPercentage(),
            createdAt: $Taxes->getCreatedAt(),
            updatedAt: $Taxes->getUpdatedAt()
        );
    }
}
