<?php

namespace App\Main\Factories\Adapters\Controller\Type;

use App\Adapters\Controller\Type\ShowTypeController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Type\ShowTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ShowTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new ShowTypeController(
            $request,
            $response,
            $args,
            ShowTypeUseCaseFactory::make()
        );

        return $controller();
    }
}
