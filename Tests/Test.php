<?php
namespace Noga\Tests;

use Noga\CLI\Renderer\Renderer;
use Noga\CLI\Renderer\Type\Enum\Color;
use Noga\Exceptions\HandleQueryException;
use Noga\Exceptions\InvalidQueryArgumentException;
use Throwable;

class Test{
      public static function handle(){
      
       

        try{
           $arr = [
          ["id"=>1,"noms"=>"noga"],
          ["id"=>2,"noms"=>"Germainio"],
          ["id"=>3,"noms"=>"Helene"]
        ];

          if(!\is_array($arr)){
              throw new InvalidQueryArgumentException("the values is not array ");
          }

          Renderer::data($arr)->arr(Color::BLUE);

        }catch(Throwable $ex){
          HandleQueryException::handle($ex,true);
        }
    } 
}
