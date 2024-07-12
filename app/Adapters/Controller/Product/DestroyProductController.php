<?php

namespace App\Adapters\Controller\Product;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Product\DestroyProductInputDto;
use App\Application\UseCase\Product\DestroyProductUseCase;
use App\Domain\Exception\Product\ProductDestroyException;
use App\Domain\Exception\Product\ProductNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DestroyProductController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly DestroyProductUseCase $destroyProductUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws ProductNotFoundException
     * @throws ProductDestroyException
     */
    protected function perform(): Response
    {
        $dto = new DestroyProductInputDto(
            id: $this->resolveArg('id')
        );

        $this->destroyProductUseCase->handle($dto);

        return $this->respondNoContent();
    }
}
