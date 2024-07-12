<?php

namespace App\Main\Factories\Adapters\Controller\Product;

use App\Adapters\Controller\Product\DestroyProductController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Product\DestroyProductUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DestroyProductControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new DestroyProductController(
                $request,
                $response,
                $args,
                DestroyProductUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
