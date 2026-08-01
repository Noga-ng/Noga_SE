<?php
declare(strict_types=1);

namespace Noga\Exceptions;

final class InvalidQueryArgumentException extends QueryException{
    public function __construct(string $message = "Error Argument is not valid")
    {
        return parent::__construct($message);
    }
}