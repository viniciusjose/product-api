<?php

declare(strict_types=1);

describe('ProductType', function () {
    it('should be type is instanceof ProductType', function () {
        $type = new App\Domain\Entities\Type(name: 'Type', description: 'Type Description');

        expect($type)->toBeInstanceOf(App\Domain\Entities\Type::class);
    });

    it('should set and get name', function () {
        $type = new App\Domain\Entities\Type(name: 'Type', description: 'Type Description');

        expect($type->getName())->toBe('Type');

        $type->setName('New Type');

        expect($type->getName())->toBe('New Type');
    });

    it('should set and get percentage', function () {
        $type = new App\Domain\Entities\Type(name: 'Type', description: 'Type Description');

        expect($type->getDescription())->toBe('Type Description');

        $type->setDescription('New Type Description');

        expect($type->getDescription())->toBe('New Type Description');
    });
});
