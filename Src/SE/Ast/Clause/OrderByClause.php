<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Clause\Clause;
use Noga\SE\Node\OrderItem;

final class OrderByClause extends Clause
{
    /**
     * @param OrderItem[] $items
     */
    public function __construct(
        public readonly array $items
    ) {}
}

// OrderByClause
// │
// └── OrderItem[]
//         │
//         ├── expression
//         └── direction


// OrderByClause
// │
// └── items
//      │
//      ├── OrderItem
//      │     │
//      │     ├── ColumnExpression
//      │     │       └── ColumnIdentifier(age)
//      │     │
//      │     └── DESC
//      │
//      └── OrderItem
//            │
//            ├── ColumnExpression
//            │       └── ColumnIdentifier(name)
//            │
//            └── ASC