<?php

namespace App\Adapters\Controller\Taxes;

use App\Adapters\Controller\Controller;
use App\Application\DTO\Taxes\StoreTaxesInputDto;
use App\Application\UseCase\Taxes\StoreTaxesUseCase;
use App\Domain\Exception\Taxes\TaxesDuplicatedException;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreTaxesController extends Controller
{
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly StoreTaxesUseCase $storeTaxesUseCase
    ) {
        parent::__construct($request, $response, $args);
    }

    /**
     * @throws TaxesDuplicatedException
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
