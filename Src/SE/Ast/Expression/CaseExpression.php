<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Node\WhenItem;

final class CaseExpression extends Expression
{
    /**
     * @param WhenItem[] $whenItems
     */
    public function __construct(
        public readonly array $whenItems,
        public readonly ?Expression $operand = null,
        public readonly ?Expression $else = null
    ) {}
}


// CaseExpression
// │
// ├── operand
// │      └── Expression|null
// │
// ├── whenClauses[]
// │       │
// │       ├── WhenClause
// │       │      ├── condition
// │       │      └── result
// │       │
// │       └── WhenClause
// │
// └── else
//        └── Expression|null



// CaseExpression
// │
// ├── operand: null
// │
// ├── whenItems
// │      │
// │      └── WhenItem
// │             │
// │             ├── condition
// │             │      │
// │             │      └── BinaryExpression
// │             │             ├── age
// │             │             ├── >=
// │             │             └── 18
// │             │
// │             └── result
// │                    └── LiteralExpression('adult')
// │
// └── else
//        └── LiteralExpression('minor')