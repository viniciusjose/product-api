<?php

declare(strict_types=1);

use App\Main\Factories\Adapters\Controller\Product\DestroyProductControllerFactory;
use App\Main\Factories\Adapters\Controller\Product\ListProductControllerFactory;
use App\Main\Factories\Adapters\Controller\Product\ShowProductControllerFactory;
use App\Main\Factories\Adapters\Controller\Product\StoreProductControllerFactory;
use App\Main\Factories\Adapters\Controller\Product\UpdateProductControllerFactory;
use App\Main\Factories\Adapters\Controller\Sale\DestroySaleControllerFactory;
use App\Main\Factories\Adapters\Controller\Sale\ListSaleControllerFactory;
use App\Main\Factories\Adapters\Controller\Sale\SaleStoreProductControllerFactory;
use App\Main\Factories\Adapters\Controller\Sale\ShowSaleControllerFactory;
use App\Main\Factories\Adapters\Controller\Sale\StoreSaleControllerFactory;
use App\Main\Factories\Adapters\Controller\Sale\UpdateSaleControllerFactory;
use App\Main\Factories\Adapters\Controller\Type\DestroyTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\Type\ShowTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\Type\StoreTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\Type\ListTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\Type\UpdateTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\Tax\DestroyTaxControllerFactory;
use App\Main\Factories\Adapters\Controller\Tax\ListTaxesControllerFactory;
use App\Main\Factories\Adapters\Controller\Tax\ShowTaxControllerFactory;
use App\Main\Factories\Adapters\Controller\Tax\StoreTaxControllerFactory;
use App\Main\Factories\Adapters\Controller\Tax\UpdateTaxControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return static function (RouteCollectorProxy $app) {
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->group('/api', function (RouteCollectorProxy $app) {
        $app->group('/sales', function (RouteCollectorProxy $app) {
            $app->get('', ListSaleControllerFactory::class);
            $app->post('', StoreSaleControllerFactory::class);
            $app->get('/{id}', ShowSaleControllerFactory::class);
            $app->put('/{id}', UpdateSaleControllerFactory::class);
            $app->delete('/{id}', DestroySaleControllerFactory::class);
            $app->post('/{id}/products', SaleStoreProductControllerFactory::class);
        });

        $app->group('/products', function (RouteCollectorProxy $app) {
            $app->get('', ListProductControllerFactory::class);
            $app->post('', StoreProductControllerFactory::class);
            $app->get('/{id}', ShowProductControllerFactory::class);
            $app->put('/{id}', UpdateProductControllerFactory::class);
            $app->delete('/{id}', DestroyProductControllerFactory::class);
        });

        $app->group('/types', function (RouteCollectorProxy $app) {
            $app->get('', ListTypeControllerFactory::class);
            $app->post('', StoreTypeControllerFactory::class);
            $app->get('/{id}', ShowTypeControllerFactory::class);
            $app->put('/{id}', UpdateTypeControllerFactory::class);
            $app->delete('/{id}', DestroyTypeControllerFactory::class);
        });

        $app->group('/taxes', function (RouteCollectorProxy $app) {
            $app->get('', ListTaxesControllerFactory::class);
            $app->post('', StoreTaxControllerFactory::class);
            $app->get('/{id}', ShowTaxControllerFactory::class);
            $app->put('/{id}', UpdateTaxControllerFactory::class);
            $app->delete('/{id}', DestroyTaxControllerFactory::class);
        });
    });
};
