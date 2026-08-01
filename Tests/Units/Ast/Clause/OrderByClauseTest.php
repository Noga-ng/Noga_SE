<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\OrderByClause;
use Noga\SE\Enum\OrderDirection;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Node\OrderItem;
use Noga\Tests\QueryTest;

final class OrderByClauseTest extends QueryTest
{
    public function testCreateOrderByWithSingleItem(): void
    {
        $orderBy = new OrderByClause([
            new OrderItem(
                new ColumnExpression(
                    new ColumnIdentifier('age')
                ),
                OrderDirection::DESC
            )
        ]);

        $this->assertCount(
            1,
            $orderBy->items
        );

        $item = $orderBy->items[0];

        $this->assertInstanceOf(
            OrderItem::class,
            $item
        );

        assert($item->expression instanceof ColumnExpression);

        $this->assertSame(
            'age',
            $item->expression->column->name
        );

        $this->assertSame(
            OrderDirection::DESC,
            $item->direction
        );
    }


    public function testCreateOrderByWithMultipleItems(): void
    {
        $orderBy = new OrderByClause([
            new OrderItem(
                new ColumnExpression(
                    new ColumnIdentifier('age')
                ),
                OrderDirection::DESC
            ),

            new OrderItem(
                new ColumnExpression(
                    new ColumnIdentifier('name')
                ),
                OrderDirection::ASC
            )
        ]);

        $this->assertCount(
            2,
            $orderBy->items
        );

    assert($orderBy->items[0]->expression instanceof ColumnExpression);

        $this->assertSame(
            'age',
            $orderBy->items[0]
                ->expression
                ->column
                ->name
        );

        $this->assertSame(
            OrderDirection::DESC,
            $orderBy->items[0]->direction
        );

         assert($orderBy->items[1]->expression instanceof ColumnExpression);

        $this->assertSame(
            'name',
            $orderBy->items[1]
                ->expression
                ->column
                ->name
        );

        $this->assertSame(
            OrderDirection::ASC,
            $orderBy->items[1]->direction
        );
    }
}