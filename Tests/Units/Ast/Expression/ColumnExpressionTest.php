<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\SchemaIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\Tests\QueryTest;

final class ColumnExpressionTest extends QueryTest
{
    public function testCreateColumnExpression(): void
    {
        $expression = new ColumnExpression(
            new ColumnIdentifier('age')
        );

        $this->assertSame(
            'age',
            $expression->column->name
        );

        $this->assertNull(
            $expression->column->table
        );
    }

    public function testCreateColumnExpressionWithTable():void{
        $expression = new ColumnExpression(
            new ColumnIdentifier(
                'name',
                new TableIdentifier(
                    'users'
                )
            )
        );

        $this->assertSame('name',$expression->column->name);
        $this->assertSame('users',$expression->column->table->name);
        $this->assertNull($expression->column->table->schema);
       
    }

    public function testCreateColumnWithAll():void{
        $expression = new ColumnExpression(
            new ColumnIdentifier(
                'name',
                new TableIdentifier(
                    'users',
                    new SchemaIdentifier('public')
                )
            )
        );

        $this->assertSame('name',$expression->column->name);
        $this->assertSame('users',$expression->column->table->name);
        $this->assertSame('public',$expression->column->table->schema->name);
    }
}