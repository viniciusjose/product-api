<?php

namespace App\Infra\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance;

    public function getInstance(): PDO
    {
        if (!is_null(self::$instance)) {
            return self::$instance;
        }

        try {
            $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']},
                dbname={$_ENV['DB_NAME']},user={$_ENV['DB_USER']},password={$_ENV['DB_PASS']}";

            self::$instance = new PDO(
                $dsn,
                [
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return self::$instance;
    }
}
