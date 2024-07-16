<?php

namespace App\Main\Factories\Adapters\Controller\Sale;

use App\Adapters\Controller\Sale\ListSaleController;
use App\Main\Factories\Application\UseCase\Sale\ListSaleUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListSaleControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $action = new ListSaleController(
            $request,
            $response,
            $args,
            ListSaleUseCaseFactory::make()
        );

        return $action();
    }
}
