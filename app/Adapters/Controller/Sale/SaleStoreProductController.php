<?php

namespace App\Adapters\Controller\Sale;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Sale\SaleStoreProductInputDto;
use App\Application\UseCase\Sale\SaleStoreProductUseCase;
use App\Domain\Exception\Sale\SaleDuplicatedException;
use App\Domain\Exception\Sale\SaleInvalidPriceException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SaleStoreProductController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly SaleStoreProductUseCase $saleStoreProductUseCase
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

        $dto = new SaleStoreProductInputDto(
            $id,
            $request['product_id'],
            $request['quantity']
        );

        $this->saleStoreProductUseCase->handle($dto);

        return $this->respondCreated();
    }
}
