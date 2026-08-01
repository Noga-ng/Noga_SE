<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Clause\Clause;

final class LimitClause extends Clause
{
    public function __construct(
        public readonly int $value
    ) {
        if ($value < 0) {
            throw new \InvalidArgumentException(
                'Limit value cannot be negative'
            );
        }
    }
}

// Clause
// │
// └── LimitClause
//        │
//        └── value : int