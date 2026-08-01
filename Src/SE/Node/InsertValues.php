<?php

declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\Expression\Expression;


final class InsertValues extends InsertSource
{
    /**
     * @param Expression[][] $rows
     */
    public function __construct(
        public readonly array $rows
    ) {}
}


// InsertValues
// │
// └── rows
//      │
//      ├── [
//      │    LiteralExpression('Noga'),
//      │    LiteralExpression(25)
//      │  ]
//      │
//      └── [
//           LiteralExpression('Jean'),
//           LiteralExpression(30)
//         ]