<?php

namespace App\Main\Factories\Adapters\Controller\Type;

use App\Adapters\Controller\Type\StoreTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Type\StoreTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StoreTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new StoreTypeController(
                $request,
                $response,
                $args,
                StoreTypeUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
