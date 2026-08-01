<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Expression\Expression;

final class ReturningClause extends Clause{
    /**
     * @param Expression[] $returning
     */
    public function __construct(
        public array $returning
    ){}
}