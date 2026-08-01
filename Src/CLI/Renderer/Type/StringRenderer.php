<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type;

use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Type\Enum\Color;
use Override;

final class StringRenderer extends Type{

    public function __construct(
       private string $data,
       private Color $color
    ){$this->handle();}

    protected function handle(): static
    {
       $this->values = $this->data;
       return $this;
    }

    public function render():void
    {
      echo Colors::paint($this->values,$this->color);
    }
}