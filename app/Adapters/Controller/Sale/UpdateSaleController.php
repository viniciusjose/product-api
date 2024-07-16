<?php

namespace App\Adapters\Controller\Sale;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Sale\UpdateSaleInputDto;
use App\Application\UseCase\Sale\UpdateSaleUseCase;
use App\Domain\Exception\Sale\SaleDuplicatedException;
use App\Domain\Exception\Sale\SaleInvalidPriceException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateSaleController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly UpdateSaleUseCase $updateSaleUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws SaleDuplicatedException
     * @throws SaleInvalidPriceException
     */
    protected function perform(): Response
    {
        $id = $this->resolveArg('id');
        $request = $this->getFormData();

        $dto = new UpdateSaleInputDto(
            $id,
            $request['customer'],
            $request['email'],
            $request['zipCode'],
            $request['address'],
            $request['addressNumber'],
            $request['description'] ?? null
        );

        $this->updateSaleUseCase->handle($dto);

        return $this->respondCreated();
    }
}
