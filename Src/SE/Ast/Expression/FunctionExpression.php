<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

final class FunctionExpression extends Expression
{
    /**
     * @param Expression[] $arguments
     */
    public function __construct(
        public readonly string $name,
        public readonly array $arguments
    ) {}
}

// COUNT(id)
// FunctionExpression
// │
// ├── name
// │     └── COUNT
// │
// └── arguments[]
//        │
//        └── ColumnExpression(id)

// COUNT(*)

// FunctionExpression
// │
// ├── name: COUNT
// │
// └── arguments
//       │
//       └── WildcardExpression
//               └── *