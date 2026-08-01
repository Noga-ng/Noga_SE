<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Color;

use Noga\CLI\Renderer\Type\Enum\Color;

class Colors{

    public function __construct(
    private Color $color,
    private mixed $text
    ){}

    public static function paint(mixed $text,Color $color):mixed{
        $instance = new static($color,$text);
        return $instance->color->apply($instance->text);
    }

    public static function warning(string $text):void{
        echo self::paint($text,Color::YELLOW);
    }

    public static function success(string $text):void{
        echo self::paint($text,Color::GREEN);
    }

    public static function error(string $text):void{
        echo self::paint($text,Color::RED);
    }


}