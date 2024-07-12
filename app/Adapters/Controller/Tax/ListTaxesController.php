<?php

namespace App\Adapters\Controller\Tax;

use App\Adapters\Controller\Controller;
use App\Application\UseCase\Tax\ListTaxesUseCase;
use App\Domain\Queries\Tax\ListTaxesQuery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListTaxesController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ListTaxesUseCase $listTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $query = $this->getQueryData();

        $data = $this->listTaxesUseCase->handle(
            new ListTaxesQuery(
                orderBy: explode(',', $query['orderBy'])
            )
        );

        return $this->respondWithData($data);
    }
}
