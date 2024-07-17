<?php

declare(strict_types=1);

use App\Domain\Exception\Tax\TaxInvalidPercentageException;

describe('Unit: App\Domain\Entities\Tax', function () {
    it('should be tax is instanceof Tax', function () {
        $tax = new App\Domain\Entities\Tax('Tax 1', 10.0 / 100);

        expect($tax)->toBeInstanceOf(App\Domain\Entities\Tax::class);
    });

    it('should set and get name', function () {
        $tax = new App\Domain\Entities\Tax('Tax 1', 10.0 / 100);

        expect($tax->getName())->toBe('Tax 1');

        $tax->setName('Tax 2');

        expect($tax->getName())->toBe('Tax 2');
    });

    it('should set and get percentage', function () {
        $tax = new App\Domain\Entities\Tax('Tax 1', 10.0 / 100);

        expect($tax->getPercentage())->toBe(0.1);

        $tax->setPercentage(11.0);

        expect($tax->getPercentage())->toBe(11.0);
    });

    it('should be throw if pass percentage zero or less than on init', function () {
        new App\Domain\Entities\Tax('Tax 1', 0);
    })->throws(TaxInvalidPercentageException::class);

    it('should be throw if set percentage less than or equal zero', function () {
        $tax = new App\Domain\Entities\Tax('Tax 1', 10.0 / 100);

        expect($tax->getPercentage())->toBe(0.1);

        $tax->setPercentage(0);
    })->throws(TaxInvalidPercentageException::class);
});
