<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type;

use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Type\Enum\Color;
use Noga\CLI\Renderer\Type\Type;

final class JsonRenderer extends Type{
    
    public function __construct(
        private mixed $data,
        private Color $color,
        private int $flag = \JSON_PRETTY_PRINT
    ){$this->handle();}

    protected function handle(): static
    {
        $this->values = \json_encode(
            $this->data,
            $this->flag
        );
        return $this;
    }

    public function render():void
    {
       echo Colors::paint($this->values,$this->color);
    }
}