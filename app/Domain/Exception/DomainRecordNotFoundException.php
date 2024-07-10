<?php

namespace App\Domain\Exception;

abstract class DomainRecordNotFoundException extends DomainException
{
    public function __construct(string $message = 'Record not found.', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
