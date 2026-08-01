<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\UnaryExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Enum\UnaryOperator;
use Noga\Tests\QueryTest;

final class UnaryExpressionTest extends QueryTest{
    public function testCreateNotExpression(): void
{
    $expression = new UnaryExpression(
        UnaryOperator::NOT,
        new ColumnExpression(
            new ColumnIdentifier('active')
        )
    );

    $this->assertSame(
        UnaryOperator::NOT,
        $expression->operator
    );

    $this->assertInstanceOf(
        ColumnExpression::class,
        $expression->expression
    );
}
}