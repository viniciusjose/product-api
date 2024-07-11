<?php

namespace App\Main\Factories\Adapters\Controller\Taxes;

use App\Adapters\Controller\Taxes\DestroyTaxesController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Taxes\DestroyTaxesUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DestroyTaxesControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new DestroyTaxesController(
                $request,
                $response,
                $args,
                DestroyTaxesUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
