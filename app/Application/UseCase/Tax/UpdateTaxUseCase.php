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
use App\Domain\Exception\Tax\TaxInvalidPercentageException;
use App\Domain\Exception\Tax\TaxNotFoundException;
use App\Domain\Exception\Tax\TaxUpdateException;
use Carbon\Carbon;
use Cassandra\Decimal;

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
     * @throws TaxInvalidPercentageException
     */
    public function handle(UpdateTaxInputDto $input): UpdateTaxOutputDto
    {
        $tax = $this->taxRepository->show($input->id);

        if ($tax === null) {
            throw new TaxNotFoundException('Tax not found.');
        }

        $duplicated = $this->taxRepository->getByName($input->name);

        if ($duplicated && $tax->getName() !== $duplicated?->getName()) {
            throw new TaxDuplicatedException('Tax name already exists.');
        }

        $tax->setName($input->name);
        $percentage = new \Decimal\Decimal((string) $input->percentage);

        $tax->setPercentage((float) $percentage->div(100)->toFixed(4));
        $tax->setUpdatedAt(Carbon::now());

        $updated = $this->taxRepository->update($tax);

        if (!$updated) {
            throw new TaxUpdateException('Tax could not be updated.');
        }

        return new UpdateTaxOutputDto(
            id: $tax->getId(),
            name: $tax->getName(),
            percentage: $tax->getPercentage(),
            createdAt: $tax->getCreatedAt(),
            updatedAt: $tax->getUpdatedAt()
        );
    }
}
