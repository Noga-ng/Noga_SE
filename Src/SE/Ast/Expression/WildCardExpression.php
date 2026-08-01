<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

final class WildcardExpression extends Expression
{}

// FunctionExpression
// │
// ├── name: COUNT
// │
// └── arguments
//       │
//       └── WildcardExpression <- usage