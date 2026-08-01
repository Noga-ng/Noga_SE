<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Statement;

use Noga\SE\Ast\Clause\WithClause;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Node\InsertSource;

final class InsertStatement extends Statement
{
    /**
     * @param ColumnIdentifier[] $columns
     */
    public function __construct(
        public readonly TableIdentifier $table,
        public readonly array $columns,
        public readonly InsertSource $source,
        ?WithClause $with = null
    ) {
        parent::__construct($with);
    }
}

// InsertStatement
// │
// ├── table
// │     └── TableIdentifier(users)
// │
// ├── columns[]
// │     ├── ColumnIdentifier(name)
// │     └── ColumnIdentifier(age)
// │
// └── values
//       └── InsertSource
//               │
//               └── rows[]
//                     │
//                     └── Expression[]