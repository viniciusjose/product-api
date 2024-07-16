<?php

namespace App\Application\UseCase\Sale;

use App\Application\DTO\Sale\SaleStoreProductInputDto;
use App\Domain\Contract\Repositories\Product\IShowProduct;
use App\Domain\Contract\Repositories\Sale\IShowSale;
use App\Domain\Contract\Repositories\SaleItem\IFindProductBySale;
use App\Domain\Contract\Repositories\SaleItem\IStoreSaleItem;
use App\Domain\Contract\Repositories\Tax\IGetTotalTaxByTypes;
use App\Domain\Entities\SaleItem;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Exception\Sale\SaleNotFoundException;
use App\Domain\Exception\SaleItem\SaleItemDuplicateProductException;
use App\Domain\Exception\SaleItem\SaleItemInvalidFieldException;
use App\Domain\Exception\SaleItem\SaleItemStoreException;
use Carbon\Carbon;
use Decimal\Decimal;

readonly class SaleStoreProductUseCase
{
    public function __construct(
        protected IShowSale $saleRepository,
        protected IStoreSaleItem|IFindProductBySale $saleItemRepository,
        protected IShowProduct $productRepository,
        protected IGetTotalTaxByTypes $taxRepository,
    ) {
    }

    /**
     * @throws SaleNotFoundException
     * @throws ProductNotFoundException
     * @throws SaleItemInvalidFieldException
     * @throws SaleItemStoreException
     * @throws SaleItemDuplicateProductException
     */
    public function handle(SaleStoreProductInputDto $input): void
    {
        $sale = $this->saleRepository->show($input->id);

        if (!$sale) {
            throw new SaleNotFoundException('Sale not found');
        }

        $product = $this->productRepository->show($input->product_id);

        if (!$product) {
            throw new ProductNotFoundException('Product not found');
        }

        $exists = $this->saleItemRepository->findProductBySale($sale->getId(), $product->getId());

        if ($exists) {
            throw new SaleItemDuplicateProductException('Product already exists in the sale');
        }

        $categories = array_map(
            static fn($category) => $category['id'],
            $product->getTypes()
        );

        $taxes = array_map(
            static fn($tax) => $tax['percentage'],
            $this->taxRepository->getTotalTaxByTypes($categories)
        );

        $taxesPercentage = new Decimal((string)array_sum($taxes));

        $price = $product->getPrice()->mul($input->quantity);
        $productTaxAmount = $price->mul($taxesPercentage);

        $item = new SaleItem(
            saleId: $sale->getId(),
            productId: $product->getId(),
            quantity: $input->quantity,
            price: $price,
            taxesAmount: $productTaxAmount,
            amount: $price->add($productTaxAmount),
            createdAt: Carbon::now(),
        );

        $isStored = $this->saleItemRepository->store($item);

        if (!$isStored) {
            throw new SaleItemStoreException('Sale item could not be stored');
        }
    }
}
