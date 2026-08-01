<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\Update\UpdateClause;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Node\Assignment;
use PHPUnit\Framework\TestCase;

final class UpdateClauseTest extends TestCase
{
    public function testCreateUpdateClause(): void
    {
        $clause = new UpdateClause(
            new TableIdentifier('users'),
            [
                new Assignment(
                        new ColumnIdentifier('name'),
                    LiteralExpression::string('Noga')
                ),
                new Assignment(
                        new ColumnIdentifier('age'),
                    LiteralExpression::integer(25)
                )
            ]
        );

        $this->assertSame(
            'users',
            $clause->table->name
        );

        $this->assertCount(
            2,
            $clause->assignments
        );

        $this->assertSame(
            'name',
            $clause->assignments[0]
                ->column
                ->name
        );

        assert($clause->assignments[0]->expression instanceof LiteralExpression);

        $this->assertSame(
            'Noga',
            $clause->assignments[0]
                ->expression->value
              
        );

        $this->assertSame(
            'age',
            $clause->assignments[1]
                ->column->name
        );

        assert($clause->assignments[1]->expression instanceof LiteralExpression);

        $this->assertSame(
            25,
            $clause->assignments[1]
                ->expression
                ->value
        );
    }

    
}