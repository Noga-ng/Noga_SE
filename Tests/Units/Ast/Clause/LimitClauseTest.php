<?php

declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\LimitClause;
use Noga\Tests\QueryTest;

final class LimitClauseTest extends QueryTest
{
    public function testCreateLimit(): void
    {
        $limit = new LimitClause(10);

        $this->assertSame(
            10,
            $limit->value
        );
    }


    public function testCannotCreateNegativeLimit(): void
    {
        $this->expectException(
            \InvalidArgumentException::class
        );

        new LimitClause(-1);
    }
}