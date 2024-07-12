<?php

namespace App\Adapters\Controller\Type;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Type\ShowTypeInputDto;
use App\Application\UseCase\Type\ShowTypeUseCase;
use App\Domain\Exception\Type\TypeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly ShowTypeUseCase $destroyTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TypeNotFoundException
     * @throws \JsonException
     */
    protected function perform(): Response
    {
        $dto = new ShowTypeInputDto(
            id: $this->resolveArg('id')
        );

        $data = $this->destroyTypeUseCase->handle($dto);

        return $this->respondWithData($data->toArray());
    }
}
