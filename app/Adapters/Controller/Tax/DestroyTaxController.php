<?php

namespace App\Adapters\Controller\Tax;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Tax\DestroyTaxInputDto;
use App\Application\UseCase\Tax\DestroyTaxUseCase;
use App\Domain\Exception\Tax\TaxDestroyException;
use App\Domain\Exception\Tax\TaxNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DestroyTaxController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly DestroyTaxUseCase $destroyTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TaxNotFoundException
     * @throws TaxDestroyException
     */
    protected function perform(): Response
    {
        $dto = new DestroyTaxInputDto(
            id: $this->resolveArg('id')
        );

        $this->destroyTaxesUseCase->handle($dto);

        return $this->respondNoContent();
    }
}
