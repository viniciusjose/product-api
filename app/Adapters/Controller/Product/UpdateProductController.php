<?php

namespace App\Adapters\Controller\Product;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Product\UpdateProductInputDto;
use App\Application\UseCase\Product\UpdateProductUseCase;
use App\Domain\Exception\Product\ProductDuplicatedException;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Exception\Product\ProductUpdateException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateProductController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly UpdateProductUseCase $updateProductUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws JsonException
     * @throws ProductDuplicatedException
     * @throws ProductUpdateException
     * @throws ProductNotFoundException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new UpdateProductInputDto(
            id: $this->resolveArg('id'),
            name: $request['name'],
            price: $request['price'],
            types: $request['types'] ?? [],
        );

        $data = $this->updateProductUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
