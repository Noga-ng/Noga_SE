<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

final class OffsetClause extends Clause
{
    public function __construct(
        public readonly int $value
    ) {
        if ($value < 0) {
            throw new \InvalidArgumentException(
                'Offset value cannot be negative'
            );
        }
    }
}

// Clause
// │
// └── OffsetClause
//        │
//        └── value : int