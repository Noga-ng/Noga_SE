<?php

declare(strict_types=1);

namespace Noga\SE\Enum;

enum BinaryOperator
{
    case EQUAL;
    case NOT_EQUAL;

    case GREATER_THAN;
    case GREATER_THAN_OR_EQUAL;

    case LESS_THAN;
    case LESS_THAN_OR_EQUAL;

    case ADD;
    case SUBTRACT;
    case MULTIPLY;
    case DIVIDE;

    case AND;
    case OR;

    case LIKE;
    case IN;
}