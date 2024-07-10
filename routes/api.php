<?php

declare(strict_types=1);

use App\Main\Factories\Adapters\Controller\ProductType\StoreProductTypeControllerFactory;
use App\Main\Factories\Adapters\Controller\ProductType\ListProductTypeControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return static function (RouteCollectorProxy $app) {
    $app->group('/api', function (RouteCollectorProxy $app) {
        $app->get('/product-types', ListProductTypeControllerFactory::class);
        $app->post('/product-types', StoreProductTypeControllerFactory::class);
    });
};
