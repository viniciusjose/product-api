<?php

namespace App\Adapters\Controller\Type;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Type\DestroyTypeInputDto;
use App\Application\UseCase\Type\DestroyTypeUseCase;
use App\Domain\Exception\Type\TypeDestroyException;
use App\Domain\Exception\Type\TypeNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DestroyTypeController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly DestroyTypeUseCase $destroyTypeUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TypeNotFoundException
     * @throws TypeDestroyException
     */
    protected function perform(): Response
    {
        $dto = new DestroyTypeInputDto(
            id: $this->resolveArg('id')
        );

        $this->destroyTypeUseCase->handle($dto);

        return $this->respondNoContent();
    }
}
