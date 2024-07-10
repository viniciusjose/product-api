<?php

declare(strict_types=1);

use App\Main\Factories\Adapters\Controller\ProductType\StoreProductTypeControllerFactory;
use Slim\Routing\RouteCollectorProxy;

return static function (RouteCollectorProxy $app) {
    $app->group('/api', function (RouteCollectorProxy $app) {
        $app->post('/product-types', StoreProductTypeControllerFactory::class);
    });
};