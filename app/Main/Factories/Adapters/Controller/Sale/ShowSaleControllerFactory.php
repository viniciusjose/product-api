<?php

namespace App\Main\Factories\Adapters\Controller\Sale;

use App\Adapters\Controller\Sale\ShowSaleController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Sale\ShowSaleUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ShowSaleControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new ShowSaleController(
            $request,
            $response,
            $args,
            ShowSaleUseCaseFactory::make()
        );

        return $controller();
    }
}
