<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Relation;

use Noga\SE\Ast\Identifier\SchemaIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\TableReference\TableReference;
use Noga\Tests\QueryTest;

final class TableReferenceTest extends QueryTest
{
    public function testCreateTableReference(): void
    {
        $table = new TableReference(
            new TableIdentifier('users')
        );

        $this->assertSame(
            'users',
            $table->table->name
        );

        $this->assertNull(
            $table->alias
        );
    }


    public function testCreateTableWithAlias(): void
    {
        $table = new TableReference(
            new TableIdentifier('users'),
            'u'
        );

        $this->assertSame(
            'u',
            $table->alias
        );
    }


    public function testCreateQualifiedTable(): void
    {
        $table = new TableReference(
            new TableIdentifier(
                'users',
                new SchemaIdentifier('public')
            )
        );

        $this->assertSame(
            'public',
            $table->table->schema->name
        );
    }
}