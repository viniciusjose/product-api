<?php

namespace App\Adapters\Controller\ProductType;

use App\Adapters\Controller\Controller;
use App\Application\UseCase\ProductType\ListProductTypeUseCase;
use App\Domain\Queries\ProductType\ListProductTypeQuery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListProductTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ListProductTypeUseCase $listProductTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $query = $this->getQueryData();

        $data = $this->listProductTypeUseCase->handle(
            new ListProductTypeQuery(
                orderBy: explode(',', $query['orderBy'])
            )
        );

        return $this->respondWithData($data);
    }
}
