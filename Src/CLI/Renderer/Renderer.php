<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer;

use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Type\ArrayRenderer;
use Noga\CLI\Renderer\Type\DumpRenderer;
use Noga\CLI\Renderer\Type\Enum\Color;
use Noga\CLI\Renderer\Type\Enum\DumperType;
use Noga\CLI\Renderer\Type\IntRenderer;
use Noga\CLI\Renderer\Type\JsonRenderer;
use Noga\CLI\Renderer\Type\StringRenderer;

final class Renderer{

    /**
     * @param string|array<mixed>|int $data
     */
    public function __construct(
        private mixed $data
    ){}

    /**
     * @param string|array<mixed>|int $data
     * @return static
     */
    public static function data(mixed $data):static{
       return new static($data);
    }


    public function json(Color $color = Color::WHITE,int $JsonFlag = \JSON_PRETTY_PRINT):void{
        (new JsonRenderer(
            $this->data,
            $color,
            $JsonFlag
            ))->render();
    }


    public function arr(Color $keyColor=Color::GREEN,Color $valColor=Color::YELLOW,int $space = 40):void{
       (new ArrayRenderer(
            \is_string($this->data) ? [$this->data] : $this->data,
            $keyColor,
            $valColor,
            $space
            ))->render();
    }


    public function dump(DumperType $type = DumperType::DUMP):void{

        (new DumpRenderer(
            $this->data,
            $type
            ))->render();
    }


    public function string(Color $color = Color::WHITE):void{
        if(!\is_string($this->data)){
            Colors::warning("data is not string, given ".\get_debug_type($this->data));
            return;
        }
         (new StringRenderer(
            $this->data,
            $color
            ))->render();
    }

    public function integer(Color $color =Color::WHITE):void{
       (new IntRenderer($this->data,$color))->render();
    }
}