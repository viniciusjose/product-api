<?php

namespace App\Adapters\Decorators\Controller;

use App\Adapters\Controller\Controller;
use App\Infra\Database\Database;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DbTransactionControllerDecorator extends Controller
{
    private PDO $db;

    public function __construct(
        Request $request,
        Response $response,
        array $args,
        private readonly Controller $decorated
    ) {
        parent::__construct($request, $response, $args);
        $this->db = Database::getInstance();
    }

    /**
     * @throws \Throwable
     */
    protected function perform(): Response
    {
        $this->db->beginTransaction();
        try {
            $decoratedRespond = $this->decorated->perform();
            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }

        return $decoratedRespond;
    }
}
