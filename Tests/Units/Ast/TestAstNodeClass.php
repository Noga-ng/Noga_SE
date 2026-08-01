<?php declare(strict_types=1);

namespace Noga\Tests\Units\Ast;

use Noga\SE\Ast\AstNode;
use Noga\Tests\QueryTest;

final class TestAstNodeClass extends QueryTest{

    public function testCanBeExtended(): void{
        $node = new class extends AstNode{};

        $this->assignedInstanceClass(AstNode::class,$node);
    }
    
}