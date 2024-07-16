<?php

namespace App\Adapters\Controller\Sale;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Sale\StoreSaleInputDto;
use App\Application\UseCase\Sale\StoreSaleUseCase;
use App\Domain\Exception\Sale\SaleDuplicatedException;
use App\Domain\Exception\Sale\SaleInvalidPriceException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreSaleController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly StoreSaleUseCase $storeSaleUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws SaleDuplicatedException
     * @throws SaleInvalidPriceException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new StoreSaleInputDto(
            $request['customer'],
            $request['email'],
            $request['zipCode'],
            $request['address'],
            $request['addressNumber'],
            $request['description'] ?? null
        );

        $this->storeSaleUseCase->handle($dto);

        return $this->respondCreated();
    }
}
