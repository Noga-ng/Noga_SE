<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type;

use Noga\CLI\Renderer\Type\Enum\DumperType;

final class DumpRenderer extends Type{

    public function __construct(
        private mixed $data,
        private DumperType $type
    ){}

    protected function handle()
    {
       match($this->type){
        DumperType::DUMP =>$this->dump(),
        DumperType::PRINT_R =>$this->printR(),
        DumperType::ECHO =>$this->text(),
        DumperType::JSON =>$this->json()
        };
    }

    private function dump():void{
        \var_dump($this->data);
    }

    private function printR():void{
        \print_r($this->data);
    }

    private function  text():void{
        echo $this->data;
    }

    private function json():void{
        echo \json_encode($this->data,\JSON_PRETTY_PRINT);
    }
    
    public function render(): void
    {
       $this->handle();
    }
}