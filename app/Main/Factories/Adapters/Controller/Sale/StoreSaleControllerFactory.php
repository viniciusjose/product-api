<?php

namespace App\Main\Factories\Adapters\Controller\Sale;

use App\Adapters\Controller\Sale\StoreSaleController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Sale\StoreSaleUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StoreSaleControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new StoreSaleController(
                $request,
                $response,
                $args,
                StoreSaleUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
