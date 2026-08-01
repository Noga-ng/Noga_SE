<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Statement;

use Noga\SE\Ast\Clause\FromClause;
use Noga\SE\Ast\Clause\SelectClause;
use Noga\SE\Ast\Clause\WithClause;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\CteExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\InsertStatement;
use Noga\SE\Ast\Statement\SelectStatement;
use Noga\SE\Ast\TableReference\NamedTableReference;
use Noga\SE\Node\InsertQuerySource;
use Noga\SE\Node\InsertValues;
use Noga\Tests\QueryTest;
use Noga\SE\Ast\Expression\LiteralExpression;

final class InsertStatementTest extends QueryTest
{
    public function testCreateInsertValues(): void
    {
        $values = new InsertValues([
            [
                LiteralExpression::string('Noga'),
                LiteralExpression::integer(25),
            ],
            [
                LiteralExpression::string('Jean'),
                LiteralExpression::integer(30),
            ],
        ]);


        $this->assertCount(
            2,
            $values->rows
        );


        $this->assertCount(
            2,
            $values->rows[0]
        );

        assert($values->rows[0][0] instanceof LiteralExpression);

        $this->assertSame(
            'Noga',
            $values->rows[0][0]->value
        );

        assert($values->rows[0][1] instanceof LiteralExpression);
        $this->assertSame(
            25,
            $values->rows[0][1]->value
        );

        assert($values->rows[1][0] instanceof LiteralExpression);
        $this->assertSame(
            'Jean',
            $values->rows[1][0]->value
        );

        assert($values->rows[1][1] instanceof LiteralExpression);

        $this->assertSame(
            30,
            $values->rows[1][1]->value
        );
    }

    public function testCreateInsertStatementWithValues(): void
{
    $statement = new InsertStatement(
        new TableIdentifier('users'),
        [
            new ColumnIdentifier('name'),
            new ColumnIdentifier('age'),
        ],
        new InsertValues([
            [
                LiteralExpression::string('Noga'),
                LiteralExpression::integer(25),
            ]
        ])
    );

    $this->assertSame(
        'users',
        $statement->table->name
    );

    $this->assertCount(
        2,
        $statement->columns
    );

    $this->assertInstanceOf(
        InsertValues::class,
        $statement->source
    );
}

// WITH active_users AS (
//     SELECT name, age
//     FROM users
// )
// INSERT INTO archive (name, age)
// SELECT name, age
// FROM active_users;

public function testCreateInsertStatementWithCte(): void
{
    $cteQuery = new SelectStatement(
        new SelectClause([
            new ColumnExpression(
                new ColumnIdentifier('name')
            ),
            new ColumnExpression(
                new ColumnIdentifier('age')
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
    ]);

    $statement = new InsertStatement(
        new TableIdentifier('archive'),
        [
            new ColumnIdentifier('name'),
            new ColumnIdentifier('age'),
        ],
        new InsertQuerySource(
            new SelectStatement(
                new SelectClause([
                    new ColumnExpression(
                        new ColumnIdentifier('name')
                    ),
                    new ColumnExpression(
                        new ColumnIdentifier('age')
                    )
                ]),
                new FromClause(
                    new NamedTableReference(
                        new TableIdentifier('active_users')
                    )
                )
            )
        ),
        $with
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

    $this->assertInstanceOf(
        InsertQuerySource::class,
        $statement->source
    );
}
}