<?php

namespace App\Main\Factories\Adapters\Controller\Type;

use App\Adapters\Controller\Type\DestroyTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Type\DestroyTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DestroyTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new DestroyTypeController(
                $request,
                $response,
                $args,
                DestroyTypeUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
