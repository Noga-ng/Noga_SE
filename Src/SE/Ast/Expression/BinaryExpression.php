<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Enum\BinaryOperator;

final class BinaryExpression extends Expression
{
    public function __construct(
        public readonly Expression $left,
        public readonly BinaryOperator $operator,
        public readonly Expression $right
    ) {}
}