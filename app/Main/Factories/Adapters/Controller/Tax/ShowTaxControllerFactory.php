<?php

namespace App\Main\Factories\Adapters\Controller\Tax;

use App\Adapters\Controller\Tax\ShowTaxController;
use App\Adapters\Decorators\Controller\DbTransactionControllerDecorator;
use App\Main\Factories\Application\UseCase\Tax\ShowTaxUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ShowTaxControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $controller = new ShowTaxController(
            $request,
            $response,
            $args,
            ShowTaxUseCaseFactory::make()
        );

        return $controller();
    }
}
