<?php

namespace App\Adapters\Controller\ProductType;

use App\Adapters\Controller\Controller;
use App\Application\DTO\ProductType\DestroyProductTypeInputDto;
use App\Application\UseCase\ProductType\DestroyProductTypeUseCase;
use App\Domain\Exception\ProductType\ProductTypeDestroyException;
use App\Domain\Exception\ProductType\ProductTypeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DestroyProductTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly DestroyProductTypeUseCase $destroyProductTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws ProductTypeNotFoundException
     * @throws ProductTypeDestroyException
     */
    protected function perform(): Response
    {
        $dto = new DestroyProductTypeInputDto(
            id: $this->resolveArg('id')
        );

        $this->destroyProductTypeUseCase->handle($dto);

        return $this->respondNoContent();
    }
}
