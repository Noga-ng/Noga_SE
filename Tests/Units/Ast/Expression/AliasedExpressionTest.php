<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\AliasedExpression;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\Tests\QueryTest;

final class AliasedExpressionTest extends QueryTest
{
    public function testCreateAliasedColumn(): void
    {
        $expression = new AliasedExpression(
            new ColumnExpression(
                new ColumnIdentifier('age')
            ),
            'user_age'
        );


        $this->assertSame(
            'user_age',
            $expression->alias
        );


        $this->assertInstanceOf(
            ColumnExpression::class,
            $expression->expression
        );
    }
}