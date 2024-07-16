<?php

namespace App\Adapters\Controller\Sale;

use App\Adapters\Controller\Controller;
use App\Application\UseCase\Sale\ListSaleUseCase;
use App\Domain\Queries\Sale\ListSaleQuery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListSaleController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ListSaleUseCase $listSaleUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $query = $this->getQueryData();

        $data = $this->listSaleUseCase->handle(
            new ListSaleQuery(
                orderBy: explode(',', $query['orderBy'] ?? 'created_at'),
            )
        );

        return $this->respondWithData($data);
    }
}
