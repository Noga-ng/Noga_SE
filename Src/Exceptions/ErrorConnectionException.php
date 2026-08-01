<?php
declare(strict_types=1);

namespace Noga\Exceptions;

final class ErrorConnectionException extends QueryException{
    public function __construct(string $message = "connection Error")
    {
        return parent::__construct($message, 402);
    }
}