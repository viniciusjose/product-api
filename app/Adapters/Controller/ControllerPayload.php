<?php

namespace App\Adapters\Controller;

use JsonSerializable;

class ControllerPayload implements JsonSerializable
{
    private int $statusCode;

    /**
     * @var array|object|null
     */
    private mixed $data;

    private ?ControllerError $error;

    public function __construct(
        int $statusCode = 200,
        $data = null,
        ?ControllerError $error = null
    ) {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->error = $error;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    public function getError(): ?ControllerError
    {
        return $this->error;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $payload = [];

        if ($this->data !== null) {
            $payload = $this->data;
        } elseif ($this->error !== null) {
            $payload['error'] = $this->error->getDescription();
        }

        return $payload;
    }
}