<?php

namespace App\Adapters\Controller\ProductType;

use App\Adapters\Controller\Controller;
use App\Application\DTO\ProductType\ShowProductTypeInputDto;
use App\Application\UseCase\ProductType\ShowProductTypeUseCase;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowProductTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ShowProductTypeUseCase $destroyProductTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws ProductTypeNotFoundException
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $dto = new ShowProductTypeInputDto(
            id: $this->resolveArg('id')
        );

        $data = $this->destroyProductTypeUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
