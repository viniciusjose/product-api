<?php

namespace App\Adapters\Controller\Sale;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Sale\ShowSaleInputDto;
use App\Application\UseCase\Sale\ShowSaleUseCase;
use App\Domain\Exception\Sale\SaleNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowSaleController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ShowSaleUseCase $showSaleUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws SaleNotFoundException
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $dto = new ShowSaleInputDto(
            id: $this->resolveArg('id')
        );

        $data = $this->showSaleUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
