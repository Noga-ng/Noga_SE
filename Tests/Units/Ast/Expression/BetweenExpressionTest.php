<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\BetweenExpression;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\Tests\QueryTest;

final class BetweenExpressionTest extends QueryTest
{
    public function testCreateBetweenExpression(): void
    {
        $between = new BetweenExpression(
            new ColumnExpression(
                new ColumnIdentifier('age')
            ),
            LiteralExpression::integer(18),
            LiteralExpression::integer(30)     
        );


        $this->assertInstanceOf(
            ColumnExpression::class,
            $between->expression
        );

        assert($between->min instanceof LiteralExpression );

        $this->assertSame(
            18,
            $between->min->value
        );
    
        assert($between->max instanceof LiteralExpression );
        $this->assertSame(
            30,
            $between->max->value
        );


        $this->assertFalse(
            $between->negated
        );
    }


    public function testCreateNotBetweenExpression(): void
    {
        $between = new BetweenExpression(
            new ColumnExpression(
                new ColumnIdentifier('age')
            ),
            LiteralExpression::integer(18),
            LiteralExpression::integer(30),
            true
        );


        $this->assertTrue(
            $between->negated
        );
    }
}