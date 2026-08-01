<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Statement;

use Noga\SE\Ast\Clause\LimitClause;
use Noga\SE\Ast\Clause\OrderByClause;
use Noga\SE\Ast\Clause\Update\UpdateClause;
use Noga\SE\Ast\Clause\WhereClause;
use Noga\SE\Ast\Clause\WithClause;

final class UpdateStatement extends Statement
{
   
    public function __construct(
        public readonly UpdateClause $updateClause,
        public readonly ?WhereClause $where = null,
        public readonly ?OrderByClause $orderBy = null,
        public readonly ?LimitClause $limit = null,
        ?WithClause $with = null
    ) {
        parent::__construct($with);
    }
}


// UpdateStatement
// │
// ├── UpdateClause
// │      │
// │      ├── table
// │      └── assignments[]
// │
// ├── WhereClause
// ├── OrderByClause
// ├── LimitClause
// └── WithClause