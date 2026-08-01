<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\Delete\DeleteClause;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\Tests\QueryTest;

final class DeleteClauseTest extends QueryTest{
    public function testCreateDeleteClause(): void
{
    $clause = new DeleteClause(
        new TableIdentifier('users')
    );

    $this->assertSame(
        'users',
        $clause->table->name
    );
}
}