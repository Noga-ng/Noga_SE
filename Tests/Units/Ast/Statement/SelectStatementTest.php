<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Statement;

use Noga\SE\Ast\Clause\FromClause;
use Noga\SE\Ast\Clause\SelectClause;
use Noga\SE\Ast\Clause\WithClause;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\CteExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\SelectStatement;
use Noga\SE\Ast\TableReference\NamedTableReference;
use Noga\Tests\QueryTest;

final class SelectStatementTest extends QueryTest{


//     SelectStatement
// │
// ├── SelectClause
// │      └── Expression[]
// │
// └── FromClause
//        │
//        ├── NamedTableReference
//        │
//        └── Join[]
    public function testCreateSelectStatement(): void
{
    $statement = new SelectStatement(
        new SelectClause([
            new ColumnExpression(
                new ColumnIdentifier('name')
            )
        ]),
        new FromClause(
            new NamedTableReference(
                new TableIdentifier('users')
            )
        )
    );


    $this->assertInstanceOf(
        SelectClause::class,
        $statement->select
    );


    $this->assertInstanceOf(
        FromClause::class,
        $statement->from
    );


    $this->assertNull(
        $statement->where
    );
}

 public function testSelectStatementWithCte(): void
    {
        $cteQuery = new SelectStatement(
            new SelectClause([
                new ColumnExpression(
                    new ColumnIdentifier('id')
                )
            ]),
            new FromClause(
                new NamedTableReference(
                    new TableIdentifier('users')
                )
            )
        );


        $cte = new CteExpression(
            new TableIdentifier('active_users'),
            $cteQuery
        );


        $with = new WithClause([
            $cte
        ],
        true);


        $statement = new SelectStatement(
            new SelectClause([
                new ColumnExpression(
                    new ColumnIdentifier('*')
                )
            ]),
            new FromClause(
                new NamedTableReference(
                    new TableIdentifier('active_users')
                )
            ),
            with: $with
        );


        $this->assertNotNull(
            $statement->with
        );


        $this->assertCount(
            1,
            $statement->with->expressions
        );


        $this->assertSame(
            'active_users',
            $statement->with->expressions[0]->name->name
        );


        $this->assertInstanceOf(
            SelectStatement::class,
            $statement->with->expressions[0]->query
        );

        $this->assertIsBool($statement->with->recursive);
    }


}