<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Node\InValueList;

final class InExpression extends Expression
{
    public function __construct(
        public readonly Expression $expression,
        public readonly InValueList $source,
        public readonly bool $negated = false
    ) {}
}

// WhereClause
// │
// └── InExpression
//       │
//       ├── ColumnExpression(id)
//       │
//       ├── InValueList
//       │       │
//       │       ├── LiteralExpression(1)
//       │       ├── LiteralExpression(2)
//       │       └── LiteralExpression(3)
//       │
//       └── false