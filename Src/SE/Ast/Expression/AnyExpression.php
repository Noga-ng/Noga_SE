<?php
declare(strict_types=1);
namespace Noga\SE\Ast\Expression;

final class AnyExpression extends Expression{
    public function __construct(
        public Expression $expression
    ){}
}