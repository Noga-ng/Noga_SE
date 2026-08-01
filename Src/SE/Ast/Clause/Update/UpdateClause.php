<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause\Update;

use Noga\SE\Ast\Clause\Clause;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Node\Assignment;


final class UpdateClause extends Clause{

    /**
     * @param Assignment[] $assignments
     */
    public function __construct(
      public readonly TableIdentifier $table,
      public readonly array $assignments
    ){}
}