<?php
declare(strict_types=1);

namespace Noga\SE\Ast\TableReference;

use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Node\Relation;

final class TableReference extends Relation
{
    public function __construct(
        public readonly TableIdentifier $table,
        public readonly ?string $alias = null
    ) {}
}


// TableReference
// │
// ├── table
// │     └── users
// │
// └── alias
//       └── null

// with alias

// TableReference
// │
// ├── table
// │     └── users
// │
// └── alias
//       └── u

// FROM public.users AS u

// TableReference
// │
// ├── table
// │     │
// │     ├── name: users
// │     │
// │     └── schema
// │            └── public
// │
// └── alias
//        └── u