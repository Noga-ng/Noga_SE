<?php
namespace Noga\Tests;

use Noga\CLI\Services\Render;
use Noga\Noga;

class Test{
      public static function handle(){
        
       $table = Noga::table(Noga::table("noga")->select("id"),"n")
        ->select(
          [Noga::table("users")
          ->select("id")
          ->where(["id"=>21]),"s"],"noms")
        ->viewState();

        $in = Noga::insert("users")
        ->columns("noms","prenoms")
        ->values("noga","Germainio")
        ->viewState();

        $up = Noga::update("users")
          ->set(["prenoms"=>"Germainio","noms"=>"noga"])
          ->where(["id"=>12])
          ->viewState();

        $del = Noga::delete("users")
          ->driver("mysql")
          ->where(["id"=>25])
          ->viewState();

       
        Render::data(
          $del
            )->json();
    } 
}
