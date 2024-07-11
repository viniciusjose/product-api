<?php

namespace App\Main\Factories\Adapters\Controller\Taxes;

use App\Adapters\Controller\Taxes\ShowTaxesController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Taxes\ShowTaxesUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ShowTaxesControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new ShowTaxesController(
            $request,
            $response,
            $args,
            ShowTaxesUseCaseFactory::make()
        );

        return $controller();
    }
}
