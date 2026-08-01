<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type\Enum;

enum Color:string{
    case WHITE= '1;37';
    case BLACK = '0;30';
    case RED = '0;31';
    case GREEN = '0;32';
    case YELLOW = '0;33';
    case BLUE = '0;34';
    case PURPLE = '0;35';
    case CYAN = '0;36';

    public function apply(mixed $text):string{
        return "\033[{$this->value}m{$text}\033[0m";
    }
}