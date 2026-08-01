<?php
declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\AstNode;
use Noga\SE\Ast\Expression\Expression;

final class InValueList extends AstNode
{
    /**
     * @param Expression[] $values
     */
    public function __construct(
        public readonly array $values
    ) {}
}

// InValueList
// │
// └── values[]
//        └── Expression