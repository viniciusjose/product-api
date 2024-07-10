<?php

namespace App\Adapters\Controller\ProductType;

use App\Adapters\Controller\Controller;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;

class StoreProductTypeController extends Controller
{

    /**
     * @throws JsonException
     */
    protected function perform(): Response
    {
        return $this->respondWithData([], 201);
    }
}