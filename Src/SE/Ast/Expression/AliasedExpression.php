<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

final class AliasedExpression extends Expression
{
    public function __construct(
        public readonly Expression $expression,
        public readonly string $alias
    ) {}
}

// AliasedExpression
// │
// ├── expression
// │       └── Expression
// │
// └── alias
//         └── future_age


// age + 10 AS future_age

// AliasedExpression
// │
// ├── expression
// │      │
// │      └── BinaryExpression
// │             │
// │             ├── ColumnExpression(age)
// │             ├── ADD
// │             └── LiteralExpression(10)
// │
// └── alias
//        └── future_age