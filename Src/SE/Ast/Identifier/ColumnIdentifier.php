<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Identifier;

final class ColumnIdentifier extends Identifier
{
    public function __construct(
        public readonly string $name,
        public readonly ?TableIdentifier $table = null
    ) {}
    
}