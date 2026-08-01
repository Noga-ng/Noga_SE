<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Ast\Expression\Expression;

final class ExistsExpression extends Expression{
    public function __construct(
        public Expression $exists
    ){}
}

