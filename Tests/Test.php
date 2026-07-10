<?php
namespace Noga\Tests;

use Noga\CLI\Services\Render;
use Noga\Noga;

class Test{
      public static function handle(){
     $builder = Noga::with(
        "categories_cte",
        Noga::table("membres", "c")
            ->select("id", "parent_id", "name")
            ->unionAll(Noga::u()
                ->from("conjointes","enfants")
            )
    ,true)
    ->table("categories_cte")
    ->select("id", "name", "category_id")
    ->where(["active" => 1])
    ->getQuery();

        Render::data($builder)->json();
    } 
}
