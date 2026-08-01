<?php

declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Identifier;

use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\SchemaIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use PHPUnit\Framework\TestCase;

final class TestIdentifier extends TestCase
{
    public function testCreateSimpleColumn(): void
    {
        $expression = new ColumnIdentifier('age');

        $this->assertSame(
            'age',
            $expression->name
        );

        $this->assertNull(
            $expression->table
        );

    }

    public function testCreateColumnWithTable():void{
        $expression = new ColumnIdentifier(
            'age',
            new TableIdentifier("users")
        );

        $this->assertSame('age',$expression->name);
        $this->assertSame("users",$expression->table->name);
        $this->assertNull($expression->table->schema);
    }

    public function testCreateAllIdentifier():void{
        $expression = new ColumnIdentifier(
            'age',
            new TableIdentifier(
                "users",
                new SchemaIdentifier("public")
                )
            );

            $this->assertSame("age",$expression->name);
            $this->assertSame($expression->table->name,"users");
            $this->assertSame("public",$expression->table->schema->name);
    }
}