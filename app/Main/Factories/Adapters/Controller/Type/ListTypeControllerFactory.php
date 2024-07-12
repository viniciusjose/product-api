<?php

namespace App\Main\Factories\Adapters\Controller\Type;

use App\Adapters\Controller\Type\ListTypeController;
use App\Main\Factories\Application\UseCase\Type\ListTypeUseCaseFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListTypeControllerFactory
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $action = new ListTypeController(
            $request,
            $response,
            $args,
            ListTypeUseCaseFactory::make()
        );

        return $action();
    }
}
