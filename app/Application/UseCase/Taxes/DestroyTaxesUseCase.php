<?php

namespace App\Application\UseCase\Taxes;

use App\Application\DTO\Taxes\DestroyTaxesInputDto;
use App\Domain\Contract\Repositories\Taxes\IDestroyTax;
use App\Domain\Contract\Repositories\Taxes\IShowTax;
use App\Domain\Exception\Taxes\TaxesDestroyException;
use App\Domain\Exception\Taxes\TaxesNotFoundException;

readonly class DestroyTaxesUseCase
{
    public function __construct(
        protected IDestroyTax|IShowTax $taxRepository
    ) {
    }

    /**
     * @throws TaxesNotFoundException
     * @throws TaxesDestroyException
     */
    public function handle(DestroyTaxesInputDto $input): void
    {
        $Taxes = $this->taxRepository->show($input->id);

        if ($Taxes === null) {
            throw new TaxesNotFoundException('Tax not found.');
        }

        $deleted = $this->taxRepository->destroy($Taxes->getId());

        if ($deleted === 0) {
            throw new TaxesDestroyException('Tax could not be deleted.');
        }
    }
}
