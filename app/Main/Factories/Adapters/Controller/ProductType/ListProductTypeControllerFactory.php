<?php

namespace App\Main\Factories\Adapters\Controller\ProductType;

use App\Adapters\Controller\ProductType\ListProductTypeController;
use App\Main\Factories\Application\UseCase\ProductType\ListProductTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListProductTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $action = new ListProductTypeController(
            $request,
            $response,
            $args,
            ListProductTypeUseCaseFactory::make()
        );

        return $action();
    }
}
