<?php

namespace App\Main\Factories\Adapters\Controller\Product;

use App\Adapters\Controller\Product\ListProductController;
use App\Main\Factories\Application\UseCase\Product\ListProductUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListProductControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $action = new ListProductController(
            $request,
            $response,
            $args,
            ListProductUseCaseFactory::make()
        );

        return $action();
    }
}
