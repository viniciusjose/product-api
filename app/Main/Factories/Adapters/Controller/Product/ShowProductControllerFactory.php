<?php

namespace App\Main\Factories\Adapters\Controller\Product;

use App\Adapters\Controller\Product\ShowProductController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Product\ShowProductUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ShowProductControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new ShowProductController(
            $request,
            $response,
            $args,
            ShowProductUseCaseFactory::make()
        );

        return $controller();
    }
}
