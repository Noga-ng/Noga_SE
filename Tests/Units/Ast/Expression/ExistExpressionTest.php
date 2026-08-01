<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Clause\FromClause;
use Noga\SE\Ast\Clause\SelectClause;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\ExistsExpression;
use Noga\SE\Ast\Expression\SubQueryExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\Statement\SelectStatement;
use Noga\SE\Ast\TableReference\TableReference;
use Noga\Tests\QueryTest;

final class ExistExpressionTest extends QueryTest{
   public function testExistEpression():void{
     $exist = new ExistsExpression(
        new SubQueryExpression(
          new SelectStatement(
            new SelectClause([
                new ColumnExpression(
                    new ColumnIdentifier("id")
                )
                ]),
                new FromClause(
                    new TableReference(
                        new TableIdentifier("users")
                    )
                )
          )      
        )
    );

    $this->assertInstanceOf(
        SubQueryExpression::class,
        $exist->exists
    );

    \assert($exist->exists instanceof SubQueryExpression);

    $this->assertInstanceOf(
        SelectStatement::class,
        $exist->exists->query
    );

   }
}