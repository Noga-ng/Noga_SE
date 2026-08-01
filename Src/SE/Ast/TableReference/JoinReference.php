<?php

declare(strict_types=1);

namespace Noga\SE\Ast\TableReference;

use Noga\SE\Ast\AstNode;
use Noga\SE\Enum\JoinType;
use Noga\SE\Ast\Expression\Expression;
use Noga\SE\Node\Relation;

final class JoinReference extends AstNode
{
    public function __construct(
        public readonly JoinType $type,
        public readonly Relation $relation,
        public readonly ?Expression $condition = null
    ) {}
}


// JoinReference
// │
// ├── type
// │     └── LEFT
// │
// ├── relation
// │     └── TableReference(profiles)
// │
// └── condition
//       └── BinaryExpression


// JoinReference
// │
// ├── Join
// │     ├── LEFT
// │     ├── profiles
// │     └── users.id = profiles.user_id
// │
// └── Join
//       ├── INNER
//       ├── roles
//       └── users.role_id = roles.id