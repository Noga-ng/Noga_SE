<?php

declare(strict_types=1);

namespace Noga\Tests\Units\Ast\Expression;

use Noga\SE\Ast\Expression\WildcardExpression;
use Noga\Tests\QueryTest;

final class WildcardExpressionTest extends QueryTest
{
    public function testCreateWildcardExpression(): void
    {
        $expression = new WildcardExpression();

        $this->assertInstanceOf(
            WildcardExpression::class,
            $expression
        );
    }
}