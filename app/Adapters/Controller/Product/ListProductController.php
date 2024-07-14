<?php

namespace App\Adapters\Controller\Product;

use App\Adapters\Controller\Controller;
use App\Application\UseCase\Product\ListProductUseCase;
use App\Domain\Queries\Product\ListProductQuery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListProductController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ListProductUseCase $listProductUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $query = $this->getQueryData();

        $data = $this->listProductUseCase->handle(
            new ListProductQuery(
                orderBy: explode(',', $query['orderBy'] ?? 'name'),
            )
        );

        return $this->respondWithData($data);
    }
}
