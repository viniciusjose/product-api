<?php

namespace App\Main\Factories\Adapters\Controller\Tax;

use App\Adapters\Controller\Tax\StoreTaxController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Tax\StoreTaxUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StoreTaxControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new StoreTaxController(
                $request,
                $response,
                $args,
                StoreTaxUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
