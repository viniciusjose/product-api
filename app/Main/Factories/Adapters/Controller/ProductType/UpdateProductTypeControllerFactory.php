<?php

namespace App\Main\Factories\Adapters\Controller\ProductType;

use App\Adapters\Controller\ProductType\UpdateProductTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\ProductType\UpdateProductTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateProductTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new UpdateProductTypeController(
                $request,
                $response,
                $args,
                UpdateProductTypeUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
