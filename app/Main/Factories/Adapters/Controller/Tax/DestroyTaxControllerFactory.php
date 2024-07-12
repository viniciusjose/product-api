<?php

namespace App\Main\Factories\Adapters\Controller\Tax;

use App\Adapters\Controller\Tax\DestroyTaxController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Tax\DestroyTaxUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DestroyTaxControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new DestroyTaxController(
                $request,
                $response,
                $args,
                DestroyTaxUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
