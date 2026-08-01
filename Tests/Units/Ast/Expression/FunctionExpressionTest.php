<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\FunctionExpression;
use Noga\SE\Ast\Expression\WildcardExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\Tests\QueryTest;

final class FunctionExpressionTest extends QueryTest
{
    public function testCreateCountWildcardFunction(): void
    {
        $expression = new FunctionExpression(
            'COUNT',
            [
                new WildcardExpression()
            ]
        );


        $this->assertSame(
            'COUNT',
            $expression->name
        );


        $this->assertCount(
            1,
            $expression->arguments
        );


        $this->assertInstanceOf(
            WildcardExpression::class,
            $expression->arguments[0]
        );
    }


    public function testCreateFunctionWithColumnArgument(): void
{
    $expression = new FunctionExpression(
        'COUNT',
        [
            new ColumnExpression(
                new ColumnIdentifier(
                    'id',
                    new TableIdentifier('users')
                )
            )
        ]
    );


    $this->assertSame(
        'COUNT',
        $expression->name
    );


    $argument = $expression->arguments[0];


    $this->assertInstanceOf(
        ColumnExpression::class,
        $argument
    );


    assert($argument instanceof ColumnExpression);


    $this->assertSame(
        'id',
        $argument->column->name
    );


    $this->assertSame(
        'users',
        $argument->column->table->name
    );
}

}