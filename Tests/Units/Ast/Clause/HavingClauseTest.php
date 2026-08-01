<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\HavingClause;
use Noga\SE\Enum\BinaryOperator;
use Noga\SE\Ast\Expression\BinaryExpression;
use Noga\SE\Ast\Expression\FunctionExpression;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Expression\WildcardExpression;
use Noga\Tests\QueryTest;

final class HavingClauseTest extends QueryTest
{
    public function testCreateHavingClause(): void
    {
        $having = new HavingClause(
            new BinaryExpression(
                new FunctionExpression(
                    'COUNT',
                    [
                        new WildcardExpression()
                    ]
                ),
                BinaryOperator::GREATER_THAN,
                LiteralExpression::integer(10)
            )
        );


        $this->assertInstanceOf(
            BinaryExpression::class,
            $having->condition
        );


        assert(
            $having->condition instanceof BinaryExpression
        );


        $this->assertSame(
            BinaryOperator::GREATER_THAN,
            $having->condition->operator
        );


        $this->assertInstanceOf(
            FunctionExpression::class,
            $having->condition->left
        );

        assert($having->condition->right instanceof LiteralExpression);

        $this->assertSame(
            10,
            $having->condition->right->value
        );
    }
}