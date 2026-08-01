<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Statement;

use Noga\SE\Ast\Clause\FromClause;
use Noga\SE\Ast\Clause\GroupByClause;
use Noga\SE\Ast\Clause\HavingClause;
use Noga\SE\Ast\Clause\LimitClause;
use Noga\SE\Ast\Clause\OffsetClause;
use Noga\SE\Ast\Clause\OrderByClause;
use Noga\SE\Ast\Clause\SelectClause;
use Noga\SE\Ast\Clause\WhereClause;
use Noga\SE\Ast\Clause\WithClause;

final class SelectStatement extends QueryStatement
{
    public function __construct(
        public readonly SelectClause $select,
        public readonly FromClause $from,
        public readonly ?WhereClause $where = null,
        public readonly ?GroupByClause $groupBy = null,
        public readonly ?HavingClause $having = null,
        public readonly ?UnionStatement $union = null,
        public readonly ?OrderByClause $orderBy = null,
        public readonly ?LimitClause $limit = null,
        public readonly ?OffsetClause $offset = null,
        ?WithClause $with = null
    ) {
        parent::__construct($with);
    }
}


// SelectStatement
// │
// ├── select
// │     └── SelectClause
// │
// ├── from
// │     └── FromClause
// │
// ├── where
// │     └── WhereClause
// │
// ├── groupBy
// │     └── GroupByClause
// │
// ├── having
// │     └── HavingClause
// │
// ├── orderBy
// │     └── OrderByClause
// │
// ├── limit
// │     └── LimitClause
// │
// └── offset
//       └── OffsetClause