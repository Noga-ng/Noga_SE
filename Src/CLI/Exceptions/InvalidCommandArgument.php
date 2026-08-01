<?php
declare(strict_types=1);

namespace Noga\CLI\Exceptions;

final class InvalidCommandArgument extends CliException{
    public function __construct(string $message = "Invalid command argument used"){}
}