<?php

declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\BinaryExpression;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Enum\BinaryOperator;
use PHPUnit\Framework\TestCase;

final class BinaryExpressionTest extends TestCase
{
    public function testCreateGreaterThanExpression(): void
    {
        $expression = new BinaryExpression(
            new ColumnExpression(
                new ColumnIdentifier('age')
            ),
            BinaryOperator::GREATER_THAN,
            LiteralExpression::integer(18)
        );

        $this->assertInstanceOf(
            ColumnExpression::class,
            $expression->left
        );

        $this->assertSame(
            BinaryOperator::GREATER_THAN,
            $expression->operator
        );

        $this->assertInstanceOf(
            LiteralExpression::class,
            $expression->right
        );
    }

    public function testCreateGreaterExpression(): void
{
    $expression = new BinaryExpression(
        new ColumnExpression(
            new ColumnIdentifier('age')
        ),
        BinaryOperator::EQUAL,
        LiteralExpression::integer(18)
    );

     assert($expression->left instanceof ColumnExpression);

    $this->assertSame(
        'age',
        $expression->left->column->name
    );

    assert($expression->right instanceof LiteralExpression);

    $this->assertSame(
        18,
        $expression->right->value
    );
}
}