<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\SelectClause;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\Tests\QueryTest;

final class SelectClauseTest extends QueryTest
{
    public function testCreateSelectClause(): void
    {
        $select = new SelectClause([
            new ColumnExpression(
                new ColumnIdentifier('age')
            )
        ]);


        $this->assertCount(
            1,
            $select->items
        );


        $this->assertInstanceOf(
            ColumnExpression::class,
            $select->items[0]
        );
    }
}