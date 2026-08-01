<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\GroupByClause;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use PHPUnit\Framework\TestCase;

final class GroupByClauseTest extends TestCase
{
    public function testCreateGroupByClause(): void
    {
        $groupBy = new GroupByClause([
            new ColumnExpression(
                new ColumnIdentifier('country')
            ),
            new ColumnExpression(
                new ColumnIdentifier('city')
            )
        ]);

        $this->assertCount(
            2,
            $groupBy->expressions
        );
        assert($groupBy->expressions[0] instanceof ColumnExpression);

        $this->assertSame(
            'country',
            $groupBy->expressions[0]
                ->column
                ->name
        );
    assert($groupBy->expressions[1] instanceof ColumnExpression);
        $this->assertSame(
            'city',
            $groupBy->expressions[1]
                ->column
                ->name
        );
    }
}