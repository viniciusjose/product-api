<?php

namespace App\Adapters\Controller\Taxes;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Taxes\DestroyTaxesInputDto;
use App\Application\UseCase\Taxes\DestroyTaxesUseCase;
use App\Domain\Exception\Taxes\TaxesDestroyException;
use App\Domain\Exception\Taxes\TaxesNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DestroyTaxesController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly DestroyTaxesUseCase $destroyTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TaxesNotFoundException
     * @throws TaxesDestroyException
     */
    protected function perform(): Response
    {
        $dto = new DestroyTaxesInputDto(
            id: $this->resolveArg('id')
        );

        $this->destroyTaxesUseCase->handle($dto);

        return $this->respondNoContent();
    }
}
