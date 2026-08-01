<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\Clause\Clause;
use Noga\SE\Ast\TableReference\TableReference;

final class UsingClause extends Clause{
    /**
     * @param TableReference[] $using
     */
    public function __construct(
        public array $using
    ){}
}