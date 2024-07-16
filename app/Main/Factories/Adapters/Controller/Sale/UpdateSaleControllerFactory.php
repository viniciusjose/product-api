<?php

namespace App\Main\Factories\Adapters\Controller\Sale;

use App\Adapters\Controller\Sale\UpdateSaleController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Sale\UpdateSaleUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateSaleControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new UpdateSaleController(
                $request,
                $response,
                $args,
                UpdateSaleUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
