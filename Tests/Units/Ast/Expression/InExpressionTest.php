<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\InExpression;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Node\InValueList;
use Noga\Tests\QueryTest;

final class InExpressionTest extends QueryTest{
    public function testCreateInExpression(): void
{
    $in = new InExpression(
        new ColumnExpression(
            new ColumnIdentifier('id')
        ),
        new InValueList([
            LiteralExpression::integer(1),
            LiteralExpression::integer(2),
            LiteralExpression::integer(3)
        ])
    );

    assert($in->expression instanceof ColumnExpression );

    $this->assertSame(
        'id',
        $in->expression->column->name
    );


    $this->assertCount(
        3,
        $in->source->values
    );


    $this->assertFalse(
        $in->negated
    );
}
}