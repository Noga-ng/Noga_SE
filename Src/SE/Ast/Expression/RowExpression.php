<?php
declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

final class RowExpression extends Expression{
    /**
     * Summary of __construct
     * @param Expression[] $row
     */
    public function __construct(
        public array $row
    ){}
}