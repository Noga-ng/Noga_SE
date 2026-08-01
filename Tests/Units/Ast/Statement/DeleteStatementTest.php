<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Statement;

use Noga\SE\Ast\Clause\Delete\DeleteClause;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\DeleteStatement;
use Noga\Tests\QueryTest;

final class DeleteStatementTest extends QueryTest{
    public function testCreateDeleteStatement(): void
{
    $statement = new DeleteStatement(
        new DeleteClause(
            new TableIdentifier('users')
        )
    );

    $this->assertSame(
        'users',
        $statement->deleteClause->table->name
    );

    $this->assertNull(
        $statement->where
    );

    $this->assertNull(
        $statement->orderBy
    );

    $this->assertNull(
        $statement->limit
    );

    $this->assertNull(
        $statement->with
    );
}
}