<?php

namespace App\Adapters\Controller\Type;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Type\StoreTypeInputDto;
use App\Application\UseCase\Type\StoreTypeUseCase;
use App\Domain\Exception\Type\TypeDuplicatedException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly StoreTypeUseCase $storeTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TypeDuplicatedException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new StoreTypeInputDto(
            $request['name'],
            $request['description'] ?? null
        );

        $this->storeTypeUseCase->handle($dto);

        return $this->respondCreated();
    }
}
