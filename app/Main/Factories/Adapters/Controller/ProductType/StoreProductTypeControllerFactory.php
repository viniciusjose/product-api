<?php

namespace App\Main\Factories\Adapters\Controller\ProductType;

use App\Adapters\Controller\ProductType\StoreProductTypeController;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StoreProductTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $action = new StoreProductTypeController($request, $response, $args);

        return $action();
    }
}