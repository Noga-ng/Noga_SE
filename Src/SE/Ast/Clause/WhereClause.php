<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Expression\Expression;

final class WhereClause extends Clause
{
    public function __construct(
        public readonly Expression $condition
    ) {}
}

// WhereClause
// │
// └── BinaryExpression
//       │
//       ├── ColumnExpression(age)
//       ├── >
//       └── LiteralExpression(18)