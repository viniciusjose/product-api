<?php

namespace App\Main\Factories\Adapters\Controller\ProductType;

use App\Adapters\Controller\ProductType\ShowProductTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\ProductType\ShowProductTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ShowProductTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new ShowProductTypeController(
                $request,
                $response,
                $args,
                ShowProductTypeUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
