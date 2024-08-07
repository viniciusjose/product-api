<?php

namespace App\Adapters\Controller;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\DomainRecordDuplicatedException;
use App\Domain\Exception\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JsonException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

abstract class Controller
{
    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __construct(
        protected Request $request,
        protected Response $response,
        protected array $args
    ) {
    }

    public function __invoke(): Response
    {
        try {
            return $this->perform();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        } catch (DomainException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws HttpBadRequestException
     */
    abstract protected function perform(): Response;

    /**
     * @return array|object|null
     */
    protected function getFormData(): array|object|null
    {
        return $this->request->getParsedBody();
    }

    /**
     * @return array|object|null
     */
    protected function getQueryData(): array|object|null
    {
        return $this->request->getQueryParams();
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function resolveArg(string $name): mixed
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param object|array|null $data
     * @param int $statusCode
     * @return Response
     * @throws JsonException
     */
    protected function respondWithData(object|array|null $data = null, int $statusCode = 200): Response
    {
        $payload = new ControllerPayload($statusCode, $data);

        return $this->respond($payload);
    }

    /**
     * @throws JsonException
     */
    protected function respond(ControllerPayload $payload): Response
    {
        $json = json_encode($payload, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }

    protected function respondCreated(): Response
    {
        return $this->response->withStatus(201);
    }

    protected function respondNoContent(): Response
    {
        return $this->response->withStatus(204);
    }
}
