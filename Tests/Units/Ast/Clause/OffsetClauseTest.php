<?php
declare(strict_types=1);

namespace Noga\SE\Tests\Units\Ast\Clause;

use Noga\SE\Ast\Clause\OffsetClause;
use Noga\Tests\QueryTest;

final class OffsetClauseTest extends QueryTest
{
    public function testCreateOffset(): void
    {
        $offset = new OffsetClause(20);

        $this->assertSame(
            20,
            $offset->value
        );
    }


    public function testCannotCreateNegativeOffset(): void
    {
        $this->expectException(
            \InvalidArgumentException::class
        );

        new OffsetClause(-5);
    }
}