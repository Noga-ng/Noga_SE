<?php

declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\AstNode;
use Noga\SE\Ast\Expression\Expression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;

final class Assignment extends AstNode
{
    public function __construct(
        public readonly ColumnIdentifier $column,
        public readonly Expression $expression
    ) {}
}

// Assignment
// │
// ├── column
// │
// └── expression
