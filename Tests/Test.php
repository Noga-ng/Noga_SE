<?php
namespace Noga\Tests;

use Noga\CLI\Services\Render;
use Noga\Noga;

class Test{
      public static function handle(){
        
       $se = Noga::delete("noga")
       ->driver('mysql')
       ->where(["id"=>12])
       ->viewState();
       
        Render::data(
          $se
            )->json();
    } 
}
