<?php

use App\Domain\Entities\SaleItem;
use App\Domain\Exception\SaleItem\SaleItemInvalidFieldException;
use Decimal\Decimal;

describe('Unit: App\Domain\Entities\SaleItem', function () {
    dataset('saleItem', [
        new SaleItem(
            saleId: 1,
            productId: 1,
            quantity: 1,
            price: new Decimal(10),
            taxesAmount: new Decimal(1),
            amount: new Decimal(11),
            id: 1
        )
    ]);

    it('should be tax is instanceof SaleItem', function (SaleItem $saleItem) {
        expect($saleItem)->toBeInstanceOf(SaleItem::class);
    })->with('saleItem');

    it('should be set and get price', function (SaleItem $saleItem) {
        $saleItem->setPrice(new Decimal(20));

        expect($saleItem->getPrice()->toFloat())->toBe(20.0);
    })->with('saleItem');

    it('should be set and get quantity', function (SaleItem $saleItem) {
        $saleItem->setQuantity(1);

        expect($saleItem->getQuantity())->toBe(1);
    })->with('saleItem');

    it('should be set and get taxes amount', function (SaleItem $saleItem) {
        $saleItem->setTaxesAmount(new Decimal(100));

        expect($saleItem->getTaxesAmount()->toFloat())->toBe(100.0);
    })->with('saleItem');

    it('should be set and get amount', function (SaleItem $saleItem) {
        $saleItem->setAmount(new Decimal((string) 110.33));

        expect($saleItem->getAmount()->toFloat())->toBe(110.33);
    })->with('saleItem');

    it('should be set and get product_id', function (SaleItem $saleItem) {
        $saleItem->setProductId(1);

        expect($saleItem->getProductId())->toBe(1);
    })->with('saleItem');

    it('should be get sale_id', function (SaleItem $saleItem) {
        expect($saleItem->getSaleId())->toBe(1);
    })->with('saleItem');

    it('should be get id', function (SaleItem $saleItem) {
        expect($saleItem->getId())->toBe(1);
    })->with('saleItem');

    it('should be throw if set price negative or zero', function (SaleItem $saleItem) {
        $saleItem->setPrice(new Decimal(-1));
    })->with('saleItem')->throws(SaleItemInvalidFieldException::class);

    it('should be throw if set quantity negative or zero', function (SaleItem $saleItem) {
        $saleItem->setQuantity(0);
    })->with('saleItem')->throws(SaleItemInvalidFieldException::class);
});
