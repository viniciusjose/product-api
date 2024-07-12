<?php

namespace App\Adapters\Controller\Product;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Product\ShowProductInputDto;
use App\Application\UseCase\Product\ShowProductUseCase;
use App\Domain\Exception\Product\ProductNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowProductController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ShowProductUseCase $destroyProductUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws ProductNotFoundException
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $dto = new ShowProductInputDto(
            id: $this->resolveArg('id')
        );

        $data = $this->destroyProductUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
