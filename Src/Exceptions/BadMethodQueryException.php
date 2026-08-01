<?php
declare(strict_types=1);

namespace Noga\Exceptions;

final class BadMethodQueryException extends QueryException{
    public function __construct(string $message = "This method is not allowed ")
    {
        return parent::__construct($message);
    }
}