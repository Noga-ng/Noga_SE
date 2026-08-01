<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type;

use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Type\Enum\Color;
use RuntimeException;

final class ArrayRenderer extends Type{

    public function __construct(
        private array $data,
        private Color $keyColor,
        private Color $valColor,
        private int $space = 40
    ){}

    protected function handle():void
    {
       try{
            foreach($this->data as $k => $v){
                if(\is_array($v)){

                $this->isArrayValues($v);

                }else{  

            \printf("%-{$this->space}s => %s\n",
                Colors::paint($k,
                $this->keyColor),
                Colors::paint(
                    \is_array($v) ?
                     \print_r($v) : $v,
                     $this->valColor
                    )
                );

            }
                
        }

    }catch(\Throwable $e){
       throw new RuntimeException($e->getMessage());
    }

    }

    private function isArrayValues(array $values):void{
        foreach($values as $c => $t){
             \printf(
                "%-{$this->space}s => %s\n",
                Colors::paint($c,$this->keyColor),
                Colors::paint(
                \is_array($t) ?
                $this->isArrayValues($t) :
                      $t,$this->valColor
                      )
                );
        }

       echo "\n{$this->line('-')}\n";

    }

    public function line(string $type = '=',int $length = 40):string{
        $line = '';
        for($i = 0;$i<$length;$i++){
            $line .= $type;
        }

        return $line;
    }

    public function render(): void
    {
        $this->handle();
    }

}