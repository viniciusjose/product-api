<?php

namespace App\Application\UseCase\Tax;

use App\Application\DTO\Tax\StoreTaxInputDto;
use App\Domain\Contract\Repositories\Tax\IGetByNameTax;
use App\Domain\Contract\Repositories\Tax\IStoreTax;
use App\Domain\Entities\Tax;
use App\Domain\Exception\Tax\TaxDuplicatedException;
use Decimal\Decimal;

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
        $taxes = $this->taxRepository->getByName($input->name);

        if ($taxes) {
            throw new TaxDuplicatedException('Tax already exists.');
        }

        $percentage = new Decimal((string) $input->percentage);

        $taxes = new Tax(
            name: $input->name,
            percentage: (float) $percentage->div(100)->toFixed(4)
        );

        $this->taxRepository->store($taxes);
    }
}
