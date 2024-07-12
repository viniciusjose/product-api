<?php

namespace App\Adapters\Controller\Tax;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Tax\StoreTaxesInputDto;
use App\Application\UseCase\Tax\StoreTaxUseCase;
use App\Domain\Exception\Tax\TaxDuplicatedException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreTaxController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly StoreTaxUseCase $storeTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TaxDuplicatedException
     */
    protected function perform(): Response
    {
        $request = $this->getFormData();

        $dto = new StoreTaxesInputDto(
            $request['name'],
            $request['percentage']
        );

        $this->storeTaxesUseCase->handle($dto);

        return $this->respondCreated();
    }
}
