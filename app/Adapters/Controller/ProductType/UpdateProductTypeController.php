<?php

namespace App\Adapters\Controller\ProductType;

use App\Adapters\Controller\Controller;
use App\Application\DTO\ProductType\StoreProductTypeInputDto;
use App\Application\DTO\ProductType\UpdateProductTypeInputDto;
use App\Application\UseCase\ProductType\StoreProductTypeUseCase;
use App\Application\UseCase\ProductType\UpdateProductTypeUseCase;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use App\Domain\Exception\ProductType\ProductTypeUpdateException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateProductTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly UpdateProductTypeUseCase $updateProductTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws JsonException
     * @throws ProductTypeDuplicatedException
     * @throws ProductTypeUpdateException
     * @throws ProductTypeNotFoundException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new UpdateProductTypeInputDto(
            id: $this->resolveArg('id'),
            name: $request['name'],
            description: $request['description'] ?? null
        );

        $data = $this->updateProductTypeUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
