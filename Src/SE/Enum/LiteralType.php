<?php
declare(strict_types=1);
namespace Noga\SE\Enum;

enum LiteralType
{
    case NULL;
    case BOOLEAN;
    case INTEGER;
    case FLOAT;
    case STRING;
}