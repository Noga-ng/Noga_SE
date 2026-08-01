<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Statement;

use Noga\SE\Enum\UnionOperator;

final class UnionStatement extends QueryStatement
{

    public function __construct(
        public readonly QueryStatement $left,
        public readonly UnionOperator $type,
        public readonly QueryStatement $right
    ) {}
}

//                  UnionStatement(ALL)
//                  /                 \
//         UnionStatement          Select(guests)
//          /          \
//  Select(users)   Select(admins)