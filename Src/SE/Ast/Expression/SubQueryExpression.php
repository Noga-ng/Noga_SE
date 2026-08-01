<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Ast\Statement\QueryStatement;

final class SubQueryExpression extends Expression
{
    public function __construct(
        public readonly QueryStatement $query
    ) {}
}