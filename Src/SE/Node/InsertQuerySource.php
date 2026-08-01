<?php

declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\Statement\QueryStatement;

final class InsertQuerySource extends InsertSource
{
    public function __construct(
        public readonly QueryStatement $query
    ) {}
}