<?php
declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\AstNode;
use Noga\SE\Enum\OrderDirection;
use Noga\SE\Ast\Expression\Expression;

final class OrderItem extends AstNode
{
    public function __construct(
        public readonly Expression $expression,
        public readonly OrderDirection $direction
    ) {}
}


// OrderItem
// │
// └── BinaryExpression
//       │
//       ├── ColumnExpression(age)
//       ├── ADD
//       └── LiteralExpression(10)