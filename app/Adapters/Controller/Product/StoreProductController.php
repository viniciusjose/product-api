<?php

namespace App\Adapters\Controller\Product;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Product\StoreProductInputDto;
use App\Application\UseCase\Product\StoreProductUseCase;
use App\Domain\Exception\Product\ProductDuplicatedException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreProductController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly StoreProductUseCase $storeProductUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws ProductDuplicatedException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new StoreProductInputDto(
            $request['name'],
            $request['percentage']
        );

        $this->storeProductUseCase->handle($dto);

        return $this->respondCreated();
    }
}
