<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Relation;

use Noga\SE\Ast\Statement\QueryStatement;
use Noga\SE\Node\Relation;

final class SubQueryRelation extends Relation
{
    public function __construct(
        public readonly QueryStatement $query,
        public readonly string $alias
    ) {}
}