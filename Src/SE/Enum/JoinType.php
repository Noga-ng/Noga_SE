<?php
declare(strict_types=1);

namespace Noga\SE\Enum;

enum JoinType
{
    case INNER;
    case LEFT;
    case RIGHT;
    case FULL;
    case CROSS;
}