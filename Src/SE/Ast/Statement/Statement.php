<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Statement;

use Noga\SE\Ast\AstNode;
use Noga\SE\Ast\Clause\WithClause;

/**
 * Base class for all SQL statements.
 */
abstract class Statement extends AstNode
{
     public function __construct(
        public readonly ?WithClause $with = null
    ) {}
}