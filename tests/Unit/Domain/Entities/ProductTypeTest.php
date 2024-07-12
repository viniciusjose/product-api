<?php

declare(strict_types=1);

describe('ProductType', function () {
    it('should be type is instanceof ProductType', function () {
        $type = new App\Domain\Entities\ProductType(name: 'Product Type', description: 'Product Type Description');

        expect($type)->toBeInstanceOf(App\Domain\Entities\ProductType::class);
    });

    it('should set and get name', function () {
        $type = new App\Domain\Entities\ProductType(name: 'Product Type', description: 'Product Type Description');

        expect($type->getName())->toBe('Product Type');

        $type->setName('New Product Type');

        expect($type->getName())->toBe('New Product Type');
    });

    it('should set and get percentage', function () {
        $type = new App\Domain\Entities\ProductType(name: 'Product Type', description: 'Product Type Description');

        expect($type->getDescription())->toBe('Product Type Description');

        $type->setDescription('New Product Type Description');

        expect($type->getDescription())->toBe('New Product Type Description');
    });
});
