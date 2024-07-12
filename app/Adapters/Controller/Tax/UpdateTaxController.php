<?php

namespace App\Adapters\Controller\Tax;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Tax\UpdateTaxInputDto;
use App\Application\UseCase\Tax\UpdateTaxUseCase;
use App\Domain\Exception\Tax\TaxDuplicatedException;
use App\Domain\Exception\Tax\TaxNotFoundException;
use App\Domain\Exception\Tax\TaxUpdateException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateTaxController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly UpdateTaxUseCase $updateTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws JsonException
     * @throws TaxDuplicatedException
     * @throws TaxUpdateException
     * @throws TaxNotFoundException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new UpdateTaxInputDto(
            id: $this->resolveArg('id'),
            name: $request['name'],
            percentage: $request['percentage']
        );

        $data = $this->updateTaxesUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
