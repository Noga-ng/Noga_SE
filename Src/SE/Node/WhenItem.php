<?php

declare(strict_types=1);

namespace Noga\SE\Node;

use Noga\SE\Ast\AstNode;
use Noga\SE\Ast\Expression\Expression;

final class WhenItem extends AstNode
{
    public function __construct(
        public readonly Expression $condition,
        public readonly Expression $result
    ) {}
}