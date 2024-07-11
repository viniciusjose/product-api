<?php

declare(strict_types=1);

use App\Main\Factories\Adapters\Controller\ProductType\DestroyProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\ShowProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\StoreProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\ListProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\UpdateProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\Taxes\DestroyTaxesControllerFactory;
use App\Main\Factories\Adapters\Controller\Taxes\ListTaxesControllerFactory;
use App\Main\Factories\Adapters\Controller\Taxes\ShowTaxesControllerFactory;
use App\Main\Factories\Adapters\Controller\Taxes\StoreTaxesControllerFactory;
use App\Main\Factories\Adapters\Controller\Taxes\UpdateTaxesControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return static function (RouteCollectorProxy $app) {
    $app->group('/api', function (RouteCollectorProxy $app) {
        $app->group('/product-types', function (RouteCollectorProxy $app) {
            $app->get('', ListProductTypeControllerFactory::class);
            $app->post('', StoreProductTypeControllerFactory::class);
            $app->get('/{id}', ShowProductTypeControllerFactory::class);
            $app->put('/{id}', UpdateProductTypeControllerFactory::class);
            $app->delete('/{id}', DestroyProductTypeControllerFactory::class);
        });

//        $app->group('/products', function (RouteCollectorProxy $app) {
//            $app->get('', ListProductControllerFactory::class);
//            $app->post('', StoreProductControllerFactory::class);
//            $app->get('/{id}', ShowProductControllerFactory::class);
//            $app->put('/{id}', UpdateProductControllerFactory::class);
//            $app->delete('/{id}', DestroyProductControllerFactory::class);
//        });

        $app->group('/taxes', function (RouteCollectorProxy $app) {
            $app->get('', ListTaxesControllerFactory::class);
            $app->post('', StoreTaxesControllerFactory::class);
            $app->get('/{id}', ShowTaxesControllerFactory::class);
            $app->put('/{id}', UpdateTaxesControllerFactory::class);
            $app->delete('/{id}', DestroyTaxesControllerFactory::class);
        });
    });
};
