<?php

namespace App\Main\Factories\Adapters\Controller\Type;

use App\Adapters\Controller\Type\UpdateTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Type\UpdateTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new UpdateTypeController(
                $request,
                $response,
                $args,
                UpdateTypeUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
