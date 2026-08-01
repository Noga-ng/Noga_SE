<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Expression\CteExpression;

final class WithClause extends Clause
{
    /**
     * @param CteExpression[] $expressions
     */
    public function __construct(
        public readonly array $expressions,
        public readonly bool $recursive = false
    ) {}
}

// SelectStatement
// │
// ├── with
// │     │
// │     └── WithClause
// │             │
// │             ├── recursive = true
// │             │
// │             └── expressions
// │                    │
// │                    └── CommonTableExpression
// │                           │
// │                           ├── name = tree
// │                           ├── columns
// │                           └── query
// │                                  └── SelectStatement
// │
// └── select