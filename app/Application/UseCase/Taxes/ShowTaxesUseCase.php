<?php

namespace App\Application\UseCase\Taxes;

use App\Application\DTO\Taxes\ShowTaxesInputDto;
use App\Application\DTO\Taxes\ShowTaxesOutputDto;
use App\Domain\Contract\Repositories\Taxes\IShowTax;
use App\Domain\Exception\Taxes\TaxesNotFoundException;

readonly class ShowTaxesUseCase
{
    public function __construct(
        protected IShowTax $taxRepository
    ) {
    }

    /**
     * @throws TaxesNotFoundException
     */
    public function handle(ShowTaxesInputDto $input): ShowTaxesOutputDto
    {
        $Taxes = $this->taxRepository->show($input->id);

        if ($Taxes === null) {
            throw new TaxesNotFoundException('Tax not found.');
        }

        return new ShowTaxesOutputDto(
            id: $Taxes->getId(),
            name: $Taxes->getName(),
            percentage: $Taxes->getPercentage(),
            createdAt: $Taxes->getCreatedAt(),
            updatedAt: $Taxes->getUpdatedAt()
        );
    }
}
