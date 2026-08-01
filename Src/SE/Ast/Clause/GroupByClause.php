<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Expression\Expression;

final class GroupByClause extends Clause
{
    /**
     * @param Expression[] $expressions
     */
    public function __construct(
        public readonly array $expressions
    ) {}

}

// GROUP BY users.country, users.city

// GroupByClause
// │
// └── expressions
//       │
//       ├── ColumnExpression
//       │       └── ColumnIdentifier
//       │             ├── country
//       │             └── users
//       │
//       └── ColumnExpression
//               └── ColumnIdentifier
//                     ├── city
//                     └── users