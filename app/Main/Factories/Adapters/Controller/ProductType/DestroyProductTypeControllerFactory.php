<?php

namespace App\Main\Factories\Adapters\Controller\ProductType;

use App\Adapters\Controller\ProductType\DestroyProductTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\ProductType\DestroyProductTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DestroyProductTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new DestroyProductTypeController(
                $request,
                $response,
                $args,
                DestroyProductTypeUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
