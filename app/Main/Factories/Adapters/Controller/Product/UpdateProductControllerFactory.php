<?php

namespace App\Main\Factories\Adapters\Controller\Product;

use App\Adapters\Controller\Product\UpdateProductController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Product\UpdateProductUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateProductControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new UpdateProductController(
                $request,
                $response,
                $args,
                UpdateProductUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
