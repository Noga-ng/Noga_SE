<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\BinaryExpression;
use Noga\SE\Ast\Expression\CaseExpression;
use Noga\SE\Ast\Expression\ColumnExpression;
use Noga\SE\Ast\Expression\LiteralExpression;
use Noga\SE\Ast\Identifier\ColumnIdentifier;
use Noga\SE\Enum\BinaryOperator;
use Noga\SE\Node\WhenItem;
use Noga\Tests\QueryTest;

final class CaseExpressionTest extends QueryTest{
    public function testCreateCaseExpression(): void
{
    $case = new CaseExpression(
        [
            new WhenItem(
                new BinaryExpression(
                    new ColumnExpression(
                        new ColumnIdentifier('age')
                    ),
                    BinaryOperator::GREATER_THAN_OR_EQUAL,
                    LiteralExpression::integer(18)
                ),
                LiteralExpression::string('adult')
            )
        ],
        null,
        LiteralExpression::string('minor')
    );


    $this->assertCount(
        1,
        $case->whenItems
    );


    $this->assertNotNull(
        $case->else
    );
}
}