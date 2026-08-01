<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Ast\Identifier\ColumnIdentifier;

final class ColumnExpression extends Expression
{
    public function __construct(
        public readonly ColumnIdentifier $column
    ) {}
}