<?php
declare(strict_types=1);

namespace Noga\Tests\Units\Renderer;

use Noga\Tests\QueryTest;

final class RendererTest extends QueryTest{
    public function testArrayRender(){
        $this->assertSame("noga","noga");
    }
    
}