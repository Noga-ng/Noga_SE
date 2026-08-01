<?php
declare(strict_types=1);
namespace Noga\SE\Ast\Expression;

use Noga\SE\Enum\TargetType;

final class CastExpression extends Expression{

    public function __construct(
        public Expression $expression,
        public TargetType $targetType
    ){}
}