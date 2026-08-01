<?php
declare(strict_types=1);
namespace Noga\SE\Ast\Expression;

final class AllExpression extends Expression{
    
    /**
     * @param Expression[] $expression
     */
    public function __construct(
        public array $expression
    ){}
}