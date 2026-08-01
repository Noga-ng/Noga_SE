<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\FromClause;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\TableReference\JoinReference;
use Noga\SE\Ast\TableReference\NamedTableReference;
use Noga\SE\Enum\JoinType;
use Noga\Tests\QueryTest;

final class FromClauseTest extends QueryTest
{
    public function testCreateFromClause(): void
    {
        $from = new FromClause(
            new NamedTableReference(
                new TableIdentifier('users')
            )
        );


        $this->assertInstanceOf(
            NamedTableReference::class,
            $from->source
        );

        \assert($from->source instanceof NamedTableReference);

        $this->assertSame(
            'users',
            $from->source->table->name
        );
    }

    public function testCreateFromWithJoins(): void
    {
        $from = new FromClause(
            new NamedTableReference(
                new TableIdentifier('users')
            ),
            [
                new JoinReference(
                    JoinType::LEFT,
                    new NamedTableReference(
                        new TableIdentifier('profiles')
                    )
                ),

                new JoinReference(
                    JoinType::INNER,
                    new NamedTableReference(
                        new TableIdentifier('roles')
                    )
                )
            ]
        );

        assert($from->source instanceof NamedTableReference);

        $this->assertSame(
            'users',
            $from->source->table->name
        );


        $this->assertCount(
            2,
            $from->joins
        );


        $this->assertSame(
            JoinType::LEFT,
            $from->joins[0]->type
        );

        assert($from->joins[0]->relation instanceof NamedTableReference );
        $this->assertSame(
            'profiles',
            $from->joins[0]->relation->table->name
        );


        $this->assertSame(
            JoinType::INNER,
            $from->joins[1]->type
        );
    }
}