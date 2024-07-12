<?php

namespace App\Adapters\Controller\Type;

use App\Adapters\Controller\Controller;
use App\Application\UseCase\Type\ListTypeUseCase;
use App\Domain\Queries\Type\ListTypeQuery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ListTypeUseCase $listTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $query = $this->getQueryData();

        $data = $this->listTypeUseCase->handle(
            new ListTypeQuery(
                orderBy: explode(',', $query['orderBy'])
            )
        );

        return $this->respondWithData($data);
    }
}
