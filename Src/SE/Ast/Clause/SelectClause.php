<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Expression\Expression;

final class SelectClause extends Clause
{
    /**
     * @param Expression[] $items
     */
    public function __construct(
        public readonly array $items
    ) {}
}

// SelectClause
// │
// └── items[]
//       │
//       ├── ColumnExpression(age)
//       │
//       ├── AliasedExpression
//       │       │
//       │       ├── ColumnExpression(name)
//       │       └── username
//       │
//       └── AliasedExpression
//               │
//               ├── BinaryExpression(price + tax)
//               └── total