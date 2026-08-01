<?php 
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

final class ArrayExpression extends Expression{
    /**
     * Summary of __construct
     * @param Expression[] $array
     */
    public function __construct(
        public array $array
    ){}
}