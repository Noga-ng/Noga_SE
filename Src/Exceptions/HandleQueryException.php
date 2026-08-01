<?php
declare(strict_types=1);

namespace Noga\Exceptions;

use Noga\CLI\Renderer\Renderer;
use Noga\CLI\Renderer\Type\Enum\Color;

final class HandleQueryException{
     public static function handle(\Throwable $e,bool $trace = false){
        
        $debug = ($trace) ? \debug_backtrace() : ["file"=>$e->getFile(),"line"=>$e->getLine()];

        Renderer::data([
            "ERROR"=>true,
            "CODE"=>$e->getCode(),
            "MESSAGE"=>$e->getMessage(),
            "DEBUG"=>[
                $debug
            ] ?? null
        ])->json(Color::RED);
    }

}