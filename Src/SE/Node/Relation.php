<?php
declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\AstNode;

abstract class Relation extends AstNode
{}

// Relation
// │
// ├── NamedTableReference
// └── SubQueryRelation