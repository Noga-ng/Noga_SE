<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Clause\Clause;
use Noga\SE\Ast\Expression\Expression;

final class HavingClause extends Clause
{
    public function __construct(
        public readonly Expression $condition
    ) {}
}


// HavingClause
// │
// └── condition
//       │
//       └── BinaryExpression
//             │
//             ├── FunctionExpression
//             │      │
//             │      ├── COUNT
//             │      └── WildcardExpression
//             │
//             ├── GREATER_THAN
//             │
//             └── LiteralExpression(10)