<?php

namespace App\Application\UseCase\Tax;

use App\Application\DTO\Tax\ShowTaxInputDto;
use App\Application\DTO\Tax\ShowTaxOutputDto;
use App\Domain\Contract\Repositories\Tax\IShowTax;
use App\Domain\Exception\Tax\TaxNotFoundException;

readonly class ShowTaxUseCase
{
    public function __construct(
        protected IShowTax $taxRepository
    ) {
    }

    /**
     * @throws TaxNotFoundException
     */
    public function handle(ShowTaxInputDto $input): ShowTaxOutputDto
    {
        $Taxes = $this->taxRepository->show($input->id);

        if ($Taxes === null) {
            throw new TaxNotFoundException('Tax not found.');
        }

        return new ShowTaxOutputDto(
            id: $Taxes->getId(),
            name: $Taxes->getName(),
            percentage: $Taxes->getPercentage(),
            createdAt: $Taxes->getCreatedAt(),
            updatedAt: $Taxes->getUpdatedAt()
        );
    }
}
