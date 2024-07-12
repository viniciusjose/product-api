<?php

namespace App\Adapters\Controller\Type;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Type\StoreTypeInputDto;
use App\Application\DTO\Type\UpdateTypeInputDto;
use App\Application\UseCase\Type\StoreTypeUseCase;
use App\Application\UseCase\Type\UpdateTypeUseCase;
use App\Domain\Exception\Type\TypeDuplicatedException;
use App\Domain\Exception\Type\TypeNotFoundException;
use App\Domain\Exception\Type\TypeUpdateException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly UpdateTypeUseCase $updateTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws JsonException
     * @throws TypeDuplicatedException
     * @throws TypeUpdateException
     * @throws TypeNotFoundException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new UpdateTypeInputDto(
            id: $this->resolveArg('id'),
            name: $request['name'],
            description: $request['description'] ?? null
        );

        $data = $this->updateTypeUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
