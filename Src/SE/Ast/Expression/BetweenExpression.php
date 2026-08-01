<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

final class BetweenExpression extends Expression
{
    public function __construct(
        public readonly Expression $expression,
        public readonly Expression $min,
        public readonly Expression $max,
        public readonly bool $negated = false
    ) {}
}

// BetweenExpression
// │
// ├── expression
// │       └── Expression
// │
// ├── min
// │       └── Expression
// │
// ├── max
// │       └── Expression
// │
// └── negated
//         └── bool

// age BETWEEN 18 AND 30

// BetweenExpression
// │
// ├── expression
// │      └── ColumnExpression(age)
// │
// ├── min
// │      └── LiteralExpression(18)
// │
// ├── max
// │      └── LiteralExpression(30)
// │
// └── negated
//        └── false

// age NOT BETWEEN 18 AND 30

// BetweenExpression
// │
// ├── expression
// │      └── ColumnExpression(age)
// │
// ├── min
// │      └── LiteralExpression(18)
// │
// ├── max
// │      └── LiteralExpression(30)
// │
// └── negated
//        └── true