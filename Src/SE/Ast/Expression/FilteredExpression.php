<?php
declare(strict_types=1);
namespace Noga\SE\Ast\Expression;

use Noga\SE\Ast\Clause\WhereClause;
use Noga\SE\Ast\Expression\Expression;

final class FilteredExpression extends Expression{

    public function __construct(
        public Expression $expression,
        public WhereClause $where
    ){}
}