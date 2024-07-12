<?php

namespace App\Main\Factories\Adapters\Controller\Tax;

use App\Adapters\Controller\Tax\ListTaxesController;
use App\Main\Factories\Application\UseCase\Tax\ListTaxesUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListTaxesControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $action = new ListTaxesController(
            $request,
            $response,
            $args,
            ListTaxesUseCaseFactory::make()
        );

        return $action();
    }
}
