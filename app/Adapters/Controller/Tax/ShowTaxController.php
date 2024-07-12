<?php

namespace App\Adapters\Controller\Tax;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Tax\ShowTaxInputDto;
use App\Application\UseCase\Tax\ShowTaxUseCase;
use App\Domain\Exception\Tax\TaxNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowTaxController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ShowTaxUseCase $destroyTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TaxNotFoundException
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $dto = new ShowTaxInputDto(
            id: $this->resolveArg('id')
        );

        $data = $this->destroyTaxesUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
