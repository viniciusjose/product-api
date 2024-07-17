<?php

use App\Application\DTO\Sale\SaleStoreProductInputDto;
use App\Application\UseCase\Sale\SaleStoreProductUseCase;
use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Contract\Repositories\SaleItem\ISaleItemRepository;
use App\Domain\Contract\Repositories\Tax\ITaxRepository;
use App\Domain\Entities\Product;
use App\Domain\Entities\Sale;
use App\Domain\Entities\SaleItem;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Exception\Sale\SaleNotFoundException;
use App\Domain\Exception\SaleItem\SaleItemDuplicateProductException;
use App\Domain\Exception\SaleItem\SaleItemStoreException;
use Carbon\Carbon;
use Decimal\Decimal;

describe('SaleStoreProductUseCase', function () {
    beforeEach(function () {
        $this->repoMock = Mockery::mock(ISaleRepository::class);
        $this->saleItemRepoMock = Mockery::mock(ISaleItemRepository::class);
        $this->productRepoMock = Mockery::mock(IProductRepository::class);
        $this->taxRepoMock = Mockery::mock(ITaxRepository::class);

        $this->repoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $this->repoMock
            ->shouldReceive('show')
            ->andReturn(
                new Sale(
                    customer: 'Customer Name',
                    email: 'any_email',
                    zipCode: 'any_zip_code',
                    address: 'any_address',
                    addressNumber: 123,
                    id: 1,
                    items: [],
                    taxesAmount: new Decimal(0),
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $this->productRepoMock
            ->shouldReceive('show')
            ->andReturn(
                new Product(
                    name: 'Product Name',
                    price: new Decimal(10),
                    id: 1,
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now(),
                    types: [
                        [
                            'id'          => 1,
                            'name'        => 'Type Name',
                            'description' => 'Type Description',
                            'created_at'  => Carbon::now(),
                            'updated_at'  => Carbon::now()
                        ]
                    ]
                )
            );

        $this->saleItemRepoMock
            ->shouldReceive('findProductBySale')
            ->andReturn(null);

        $this->saleItemRepoMock
            ->shouldReceive('store')
            ->andReturn(1);

        $this->taxRepoMock
            ->shouldReceive('getTotalTaxByTypes')
            ->andReturn(
                [
                    [
                        'name'       => 'Tax Name',
                        'percentage' => 0.18,
                    ]
                ]
            );

        $this->sut = new SaleStoreProductUseCase(
            $this->repoMock,
            $this->saleItemRepoMock,
            $this->productRepoMock,
            $this->taxRepoMock
        );
    });

    it('should be instance of store Sale use case', function () {
        expect($this->sut)->toBeInstanceOf(SaleStoreProductUseCase::class);
    });

    it('should be store sale', function () {
        $this->sut->handle(
            new SaleStoreProductInputDto(
                id: 1,
                product_id: 1,
                quantity: 1
            )
        );

        expect(true)->toBeTrue();
    });

    it('should be throw if sales not exists', function () {
        $saleRepoMock = Mockery::mock(ISaleRepository::class);
        $saleRepoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new SaleStoreProductUseCase(
            $saleRepoMock,
            $this->saleItemRepoMock,
            $this->productRepoMock,
            $this->taxRepoMock
        );

        $sut->handle(
            new SaleStoreProductInputDto(
                id: 1,
                product_id: 1,
                quantity: 1
            )
        );
    })->throws(SaleNotFoundException::class);

    it('should be throw if product not exists', function () {
        $productRepoMock = Mockery::mock(IProductRepository::class);
        $productRepoMock
            ->shouldReceive('show')
            ->andReturn(null);

        $sut = new SaleStoreProductUseCase(
            $this->repoMock,
            $this->saleItemRepoMock,
            $productRepoMock,
            $this->taxRepoMock
        );

        $sut->handle(
            new SaleStoreProductInputDto(
                id: 1,
                product_id: 1,
                quantity: 1
            )
        );
    })->throws(ProductNotFoundException::class);

    it('should be throw if product exists on sale', function () {
        $saleItemRepoMock = Mockery::mock(ISaleItemRepository::class);
        $saleItemRepoMock
            ->shouldReceive('findProductBySale')
            ->andReturn(
                new SaleItem(
                    saleId: 1,
                    productId: 1,
                    quantity: 1,
                    price: new Decimal(10),
                    taxesAmount: new Decimal(1),
                    amount: new Decimal(11),
                    createdAt: Carbon::now(),
                    updatedAt: Carbon::now()
                )
            );

        $sut = new SaleStoreProductUseCase(
            $this->repoMock,
            $saleItemRepoMock,
            $this->productRepoMock,
            $this->taxRepoMock
        );

        $sut->handle(
            new SaleStoreProductInputDto(
                id: 1,
                product_id: 1,
                quantity: 1
            )
        );
    })->throws(SaleItemDuplicateProductException::class);

    it('should be throw if sale item could not be store', function () {
        $saleItemRepoMock = Mockery::mock(ISaleItemRepository::class);

        $saleItemRepoMock
            ->shouldReceive('findProductBySale')
            ->andReturn(null);

        $saleItemRepoMock
            ->shouldReceive('store')
            ->andReturn(false);

        $sut = new SaleStoreProductUseCase(
            $this->repoMock,
            $saleItemRepoMock,
            $this->productRepoMock,
            $this->taxRepoMock
        );

        $sut->handle(
            new SaleStoreProductInputDto(
                id: 1,
                product_id: 1,
                quantity: 1
            )
        );
    })->throws(SaleItemStoreException::class);
});
