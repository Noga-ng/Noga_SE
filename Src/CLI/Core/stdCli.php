<?php
declare(strict_types=1);

namespace Noga\CLI\Core;

final class StdCli{
      
    private string $input;
    private string $question;

    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function ask(string $question,?string $default = null){
        
    }

}