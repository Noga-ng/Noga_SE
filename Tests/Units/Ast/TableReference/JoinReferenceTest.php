<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\TableReference;

use Noga\SE\Ast\Expression\BinaryExpression;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Ast\Identifier\TableIdentifier;
use Noga\SE\Ast\TableReference\JoinReference;
use Noga\SE\Ast\TableReference\TableReference;
use Noga\SE\Enum\BinaryOperator;
use Noga\SE\Enum\JoinType;
use Noga\Tests\QueryTest;

final class JoinReferenceTest extends QueryTest
{
    public function testCreateLeftJoinWithoutCondition(): void
    {
        $join = new JoinReference(
            JoinType::LEFT,
            new TableReference(
                new TableIdentifier('profiles')
            )
        );

        $this->assertSame(
            JoinType::LEFT,
            $join->type
        );

        assert($join->relation instanceof TableReference);
        $this->assertSame(
            'profiles',
            $join->relation->table->name
        );

        $this->assertNull(
            $join->condition
        );
    }

    public function testCreateInnerJoinWithCondition(): void
{
    $join = new JoinReference(
        JoinType::INNER,
        new TableReference(
            new TableIdentifier('profiles')
        ),
        new BinaryExpression(
            new ColumnExpression(
                new ColumnIdentifier(
                    'id',
                    new TableIdentifier('users')
                )
            ),
            BinaryOperator::EQUAL,
            new ColumnExpression(
                new ColumnIdentifier(
                    'user_id',
                    new TableIdentifier('profiles')
                )
            )
        )
    );


    $this->assertInstanceOf(
        BinaryExpression::class,
        $join->condition
    );
}
}