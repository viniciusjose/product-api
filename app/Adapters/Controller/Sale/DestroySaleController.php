<?php

namespace App\Adapters\Controller\Sale;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Sale\DestroySaleInputDto;
use App\Application\UseCase\Sale\DestroySaleUseCase;
use App\Domain\Exception\Sale\SaleDestroyException;
use App\Domain\Exception\Sale\SaleNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DestroySaleController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly DestroySaleUseCase $destroySaleUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws SaleNotFoundException
     * @throws SaleDestroyException
     */
    protected function perform(): Response
    {
        $dto = new DestroySaleInputDto(
            id: $this->resolveArg('id')
        );

        $this->destroySaleUseCase->handle($dto);

        return $this->respondNoContent();
    }
}
