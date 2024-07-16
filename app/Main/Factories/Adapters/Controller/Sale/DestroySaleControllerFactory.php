<?php

namespace App\Main\Factories\Adapters\Controller\Sale;

use App\Adapters\Controller\Sale\DestroySaleController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Sale\DestroySaleUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DestroySaleControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new DestroySaleController(
                $request,
                $response,
                $args,
                DestroySaleUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
