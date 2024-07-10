<?php

namespace App\Domain\Exception;

abstract class DomainRecordDuplicatedException extends DomainException
{
    public function __construct(string $message = 'Already exists.', int $code = 409)
    {
        parent::__construct($message, $code);
    }
}
