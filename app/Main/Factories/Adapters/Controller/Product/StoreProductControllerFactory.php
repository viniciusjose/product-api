<?php

namespace App\Main\Factories\Adapters\Controller\Product;

use App\Adapters\Controller\Product\StoreProductController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Product\StoreProductUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StoreProductControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new StoreProductController(
                $request,
                $response,
                $args,
                StoreProductUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
