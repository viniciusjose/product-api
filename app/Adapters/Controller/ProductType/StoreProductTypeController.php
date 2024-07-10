<?php

namespace App\Adapters\Controller\ProductType;

use App\Adapters\Controller\Controller;
use App\Application\DTO\ProductType\StoreProductTypeInputDto;
use App\Application\UseCase\ProductType\StoreProductTypeUseCase;
use App\Domain\Exception\ProductType\ProductTypeDuplicatedException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreProductTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly StoreProductTypeUseCase $storeProductTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws JsonException
     * @throws ProductTypeDuplicatedException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new StoreProductTypeInputDto(
            $request['name'],
            $request['description'] ?? null
        );

        $this->storeProductTypeUseCase->handle($dto);

        return $this->respondCreated();
    }
}
