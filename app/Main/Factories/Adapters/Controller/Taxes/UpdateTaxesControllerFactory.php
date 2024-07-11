<?php

namespace App\Main\Factories\Adapters\Controller\Taxes;

use App\Adapters\Controller\Taxes\UpdateTaxesController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Taxes\UpdateTaxesUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateTaxesControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new DbTransactionControllerDecorator(
            $request,
            $response,
            $args,
            new UpdateTaxesController(
                $request,
                $response,
                $args,
                UpdateTaxesUseCaseFactory::make()
            )
        );

        return $controller();
    }
}
