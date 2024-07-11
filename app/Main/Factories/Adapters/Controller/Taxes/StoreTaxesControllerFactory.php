<?php

namespace App\Main\Factories\Adapters\Controller\Taxes;

use App\Adapters\Controller\Taxes\StoreTaxesController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Taxes\StoreTaxesUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StoreTaxesControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new StoreTaxesController(
                $request,
                $response,
                $args,
                StoreTaxesUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
