<?php

namespace App\Adapters\Controller\Taxes;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Taxes\UpdateTaxesInputDto;
use App\Application\UseCase\Taxes\UpdateTaxesUseCase;
use App\Domain\Exception\Taxes\TaxesDuplicatedException;
use App\Domain\Exception\Taxes\TaxesNotFoundException;
use App\Domain\Exception\Taxes\TaxesUpdateException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateTaxesController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly UpdateTaxesUseCase $updateTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws JsonException
     * @throws TaxesDuplicatedException
     * @throws TaxesUpdateException
     * @throws TaxesNotFoundException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new UpdateTaxesInputDto(
            id: $this->resolveArg('id'),
            name: $request['name'],
            percentage: $request['percentage']
        );

        $data = $this->updateTaxesUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
