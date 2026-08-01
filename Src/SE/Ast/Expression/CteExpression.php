<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\Statement;

final class CteExpression extends Expression{

    /**
     * @param ColumnIdentifier[] $columns
     */
    public function __construct(
        public readonly TableIdentifier $name,
        public readonly Statement $query,
        public readonly array $columns = []
    ) {}
}

// CteExpression
// │
// ├── name
// │      └── TableIdentifier
// │
// ├── statement
// │      │
// │      ├── SelectStatement
// │      ├── UnionStatement
// │      ├── InsertStatement
// │      ├── UpdateStatement
// │      └── DeleteStatement
// │
// └── columns
//        └── ColumnIdentifier[]