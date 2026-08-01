<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type;

use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Type\Enum\Color;
use Override;

final class IntRenderer extends Type{

    public function __construct(
        private int $data,
        private Color $color
    ){$this->handle();}

    public function handle():static
    {
        $this->values = $this->data;
        return $this;    
    }

    public function render():void
    {
        echo Colors::paint($this->values,$this->color);
    }
}