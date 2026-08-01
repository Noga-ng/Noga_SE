<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Enum\UnaryOperator;

final class UnaryExpression extends Expression
{
    public function __construct(
        public readonly UnaryOperator $operator,
        public readonly Expression $expression
    ) {}
}

// UnaryExpression
// │
// ├── operator
// │      └── NOT
// │
// └── expression
//        │
//        └── ColumnExpression(active)