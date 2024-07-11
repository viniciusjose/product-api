<?php

namespace App\Adapters\Controller\Taxes;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Taxes\ShowTaxesInputDto;
use App\Application\UseCase\Taxes\ShowTaxesUseCase;
use App\Domain\Exception\Taxes\TaxesNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowTaxesController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ShowTaxesUseCase $destroyTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TaxesNotFoundException
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $dto = new ShowTaxesInputDto(
            id: $this->resolveArg('id')
        );

        $data = $this->destroyTaxesUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
