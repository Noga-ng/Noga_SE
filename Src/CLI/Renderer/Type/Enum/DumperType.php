<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type\Enum;

enum DumperType{
    case DUMP;
    case PRINT_R;
    case ECHO;
    case JSON;
}