<?php
declare(strict_types=1);

namespace Noga\CLI\Exceptions;

final class BadCommandException extends CliException{
    public function __construct(string $message = "Bad command used "){}
}