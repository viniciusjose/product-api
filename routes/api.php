<?php

declare(strict_types=1);

use App\Main\Factories\Adapters\Controller\ProductType\DestroyProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\ShowProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\StoreProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\ListProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\UpdateProductTypeControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return static function (RouteCollectorProxy $app) {
    $app->group('/api', function (RouteCollectorProxy $app) {
        $app->get('/product-types', ListProductTypeControllerFactory::class);
        $app->post('/product-types', StoreProductTypeControllerFactory::class);
        $app->get('/product-types/{id}', ShowProductTypeControllerFactory::class);
        $app->put('/product-types/{id}', UpdateProductTypeControllerFactory::class);
        $app->delete('/product-types/{id}', DestroyProductTypeControllerFactory::class);
    });
};
