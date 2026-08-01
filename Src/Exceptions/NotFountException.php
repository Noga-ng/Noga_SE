<?php
declare(strict_types=1);

namespace Noga\Exceptions;

final class NotFountException extends QueryException{
    public function __construct(string $message = "Not found !"){}
}