<?php

namespace App\Application\UseCase\Tax;

use App\Application\DTO\Tax\DestroyTaxesInputDto;
use App\Domain\Contract\Repositories\Tax\IDestroyTax;
use App\Domain\Contract\Repositories\Tax\IShowTax;
use App\Domain\Exception\Tax\TaxDestroyException;
use App\Domain\Exception\Tax\TaxNotFoundException;

readonly class DestroyTaxUseCase
{
    public function __construct(
        protected IDestroyTax|IShowTax $taxRepository
    ) {
    }

    /**
     * @throws TaxNotFoundException
     * @throws TaxDestroyException
     */
    public function handle(DestroyTaxesInputDto $input): void
    {
        $Taxes = $this->taxRepository->show($input->id);

        if ($Taxes === null) {
            throw new TaxNotFoundException('Tax not found.');
        }

        $deleted = $this->taxRepository->destroy($Taxes->getId());

        if ($deleted === 0) {
            throw new TaxDestroyException('Tax could not be deleted.');
        }
    }
}
