<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause\Delete;

use Noga\SE\Ast\Clause\Clause;
use Noga\SE\Ast\Identifier\TableIdentifier;

final class DeleteClause extends Clause
{
    public function __construct(
        public readonly TableIdentifier $table
    ) {}
}

// DeleteClause
// │
// └── table
//       └── TableIdentifier