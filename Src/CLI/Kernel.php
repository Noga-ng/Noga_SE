<?php 
declare(strict_types=1);
namespace Noga\CLI;

use Noga\CLI\Command\Command;
use Noga\CLI\Exceptions\BadMethodCommandException;
use Noga\CLI\Exceptions\HandleCliException;
use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Renderer;
use Noga\CLI\Services\Init;
use Noga\Tests\Test;
use Throwable;

class Kernel{
   private array $argv = [];
   private array $command = [
    '-h'=>'help',
    'init'=>'initialise',
    '-v'=>'version'
   ];
   private static ?self $instance = null;

   public function __construct(array $args)
   {
    $this->argv = $args;
    foreach($this->command ?? [] as $k=>$com){
      Command::get()->add($k,$com);
    }
    
    $this->command = \array_merge(
      Command::get()->list(),
      $this->command);

     $this->command = \array_unique($this->command,\SORT_ASC);

   }

   public static function run(array $args):kernel{
      if(static::$instance === null){
          static::$instance = new static($args);
      }
      static::$instance->handle();

    return static::$instance;

   }

   public function handle():void{
      try{

     $this->boot();
     $this->class_handle();
     $this->auto_command();

      }catch(Throwable $e){
         HandleCliException::handle($e);
      }
    
     }

    private function boot(){
        if(!isset($this->argv[1])){
      Init::boot($this->command);
         return;

     }else if($this->argv[1] == '-v'){

      Colors::success(" Noga version ".\NOGA_SE_VERSION);

     }else if($this->argv[1] == 'init'){
      
      (new Init($this->argv))->init();

     }else if($this->argv[1] == '-h'){
         Renderer::data($this->command)->arr();
         return;
     }else if($this->argv[1] == 'Test'){
         Test::handle();
     }

    }


public function class_handle(){

     if(preg_match('/^([A-Za-z_]+)@([A-Za-z_]+)$/',$this->argv[1],$m)){  
      $class = $this->command[$m[1]];
      if(!isset($class) || !\class_exists($class)){
         throw new BadMethodCommandException("class is not defined {$class}");
      }

      $handle = $m[2];

      if(!\method_exists($class,$handle)){
           throw new BadMethodCommandException("method {$handle} is not defined in class {$class}");
      }

      $class::$handle();

      }

   }

      public function auto_command(){
         if($this->argv[1] === 'command'){
            $function = "handle";
            if(isset($this->argv[2])){

               $function  = match(($this->argv[2] ?: '')){
                  '--dump'=>'put',
                  '--d'=>'put',
                  '--show'=>'show',
                  '--s'=>'show',
                  '--clear'=>'clear',
                  '--c'=>'clear',
                 default => 'handle' 
               };
                
            }

             Command::get()->$function();
         }
      }
}
