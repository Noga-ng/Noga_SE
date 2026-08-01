<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Statement;

use Noga\SE\Ast\Clause\Update\UpdateClause;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\UpdateStatement;
use Noga\SE\Node\Assignment;
use Noga\Tests\QueryTest;


final class UpdateStatementTest extends QueryTest{
    public function testCreateUpdateStatement(): void
{
    $statement = new UpdateStatement(
        new UpdateClause(
            new TableIdentifier('users'),
            [
                new Assignment(
                        new ColumnIdentifier('name'),
                    LiteralExpression::string('Noga')
                )
            ]
        )
    );

    $this->assertSame(
        'users',
        $statement->updateClause->table->name
    );

    $this->assertCount(
        1,
        $statement->updateClause->assignments
    );

    $this->assertNull(
        $statement->where
    );

    $this->assertNull(
        $statement->with
    );
}
}