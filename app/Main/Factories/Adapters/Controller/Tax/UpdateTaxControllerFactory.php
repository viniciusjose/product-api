<?php

namespace App\Main\Factories\Adapters\Controller\Tax;

use App\Adapters\Controller\Tax\UpdateTaxController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Tax\UpdateTaxUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateTaxControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new UpdateTaxController(
                $request,
                $response,
                $args,
                UpdateTaxUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
