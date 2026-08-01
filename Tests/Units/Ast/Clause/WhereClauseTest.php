<?php
declare(strict_types=1);

namespace Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\WhereClause;
use Noga\SE\Ast\Expression\BinaryExpression;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Enum\BinaryOperator;
use Noga\Tests\QueryTest;

final class WhereClauseTest extends QueryTest{

    public function testCreateWhereClause(): void
{
    $where = new WhereClause(
        new BinaryExpression(
            new ColumnExpression(
                new ColumnIdentifier('age')
            ),
            BinaryOperator::GREATER_THAN,
            LiteralExpression::integer(18)
        )
    );

    $this->assertInstanceOf(
        BinaryExpression::class,
        $where->condition
    );
}
}