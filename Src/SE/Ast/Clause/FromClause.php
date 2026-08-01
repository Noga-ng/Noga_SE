<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Clause;

use Noga\SE\Ast\TableReference\JoinReference;
use Noga\SE\Node\Relation;

final class FromClause extends Clause
{
    /**
     * @param JoinReference[] $joins
     */
    public function __construct(
        public readonly Relation $source,
        public readonly array $joins = []
    ) {}
}

// FromClause
// │
// └── source
//        │
//        └── NamedTableReference
//               │
//               └── TableIdentifier(users)


// FROM users
// LEFT JOIN profiles
// ON users.id = profiles.user_id
// INNER JOIN roles
// ON users.role_id = roles.id


// FromClause
// │
// ├── source
// │     │
// │     └── NamedTableReference(users)
// │
// └── joinReference
//       │
//       ├── Join
//       │     │
//       │     ├── LEFT
//       │     ├── NamedTableReference(profiles)
//       │     └── BinaryExpression
//       │
//       └── Join
//             │
//             ├── INNER
//             ├── NamedTableReference(roles)
//             └── BinaryExpression