<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Statement;

use Noga\SE\Ast\Clause\FromClause;
use Noga\SE\Ast\Clause\SelectClause;
use Noga\SE\Ast\Expression\WildcardExpression;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\SelectStatement;
use Noga\SE\Ast\Statement\UnionStatement;
use Noga\SE\Ast\TableReference\NamedTableReference;
use Noga\SE\Enum\UnionOperator;
use Noga\Tests\QueryTest;

final class UnionStatementTest extends QueryTest{

   public function testCreateUnionStatement(): void
{
    $left = new SelectStatement(
        new SelectClause([
            new WildcardExpression()
        ]),
        new FromClause(
            new NamedTableReference(
                new TableIdentifier('users')
            )
        )
    );

    $right = new SelectStatement(
        new SelectClause([
            new WildcardExpression()
        ]),
        new FromClause(
            new NamedTableReference(
                new TableIdentifier('admins')
            )
        )
    );

    $union = new UnionStatement(
        $left,
        UnionOperator::UNION,
        $right
    );

    $this->assertSame(
        UnionOperator::UNION,
        $union->type
    );

    $this->assertSame(
        $left,
        $union->left
    );

    $this->assertSame(
        $right,
        $union->right
    );
}
}
