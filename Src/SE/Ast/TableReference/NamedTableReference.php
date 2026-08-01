<?php
declare(strict_types=1);

namespace Noga\SE\Ast\TableReference;

use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Node\Relation;

final class NamedTableReference extends Relation
{
    public function __construct(
        public readonly TableIdentifier $table,
        public readonly ?string $alias = null
    ) {}
}