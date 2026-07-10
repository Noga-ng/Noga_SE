<?php
namespace Noga\Tests\Units\Builder\Select;

use Noga\Noga;
use Noga\Tests\QueryTest;

class SelectTest extends QueryTest{
    public function testSelectBasic(){
        //select * 
        $builder = Noga::table("users");
        $expect = <<<SQL
        SELECT * FROM users
        SQL;

        $this->assertSqlEquals($expect,$builder);

        //select with columns specified
        $builder1 = Noga::table("users")->select("id","noms","prenoms");
        $expect1 = <<<SQL
        SELECT id,noms,prenoms FROM users
        SQL;

        $this->assertBuilderSql($expect1,$builder1);

        //SELECT DISTINCT
        $builder2 = $builder1->distinct(true);

        $expect2 = <<<SQL
            SELECT DISTINCT id,noms,prenoms FROM users
        SQL;

        $this->assertBuilderSql($expect2,$builder2);

    }

    public function testSelectOrder(){
        $builder = Noga::table("users")
        ->select("id","noms");
        
        // default ASC
        $asc = $builder->orderBy("id");

        $expect = <<<SQL
            SELECT id,noms FROM users ORDER BY id ASC
        SQL;

        $this->assertBuilderSql($expect,$asc);

        $desc = $builder->orderBy("id","DESC");

         $expect1 = <<<SQL
            SELECT id,noms FROM users ORDER BY id DESC
        SQL;

         $this->assertBuilderSql($expect1,$desc);
    }

    public function testSelectLimit(){
         $builder = Noga::table("users")
        ->select("id","noms")
        ->limit(20);
        
        $expect = <<<SQL
            SELECT id,noms FROM users LIMIT 20
        SQL;

        $this->assertBuilderSql($expect,$builder);
    }

    public function testSelectOffset(){
         $builder = Noga::table("users")
        ->select("id","noms")
        ->offset(20);
        
        $expect = <<<SQL
            SELECT id,noms FROM users OFFSET 20
        SQL;

        $this->assertBuilderSql($expect,$builder);
    }

    public function testPaginationWithOrder(){
         $builder = Noga::table("users")
        ->select("id","noms")
        ->orderBy("id")
        ->limit(100)
        ->offset(20);
        
        $expect = <<<SQL
            SELECT id,noms FROM users ORDER BY id ASC LIMIT 100 OFFSET 20
        SQL;

        $this->assertBuilderSql($expect,$builder);
    }


    public function testSelectSql(){
        $builder = Noga::table("users")
        ->select("id","noms","prenoms","birthday","age","phone")
        ->orderBy("id","DESC")
        ->limit(100)
        ->offset(50);

         $expect = <<<SQL
            SELECT id,noms,prenoms,birthday,age,phone FROM users ORDER BY id DESC LIMIT 100 OFFSET 50
        SQL;

        $this->assertBuilderSql($expect,$builder);

    }

    // public function testSelectSimpleWithClause(){
    //     $expected = <<<SQL
    //         SELECT DISTINCT id
    //         FROM users
    //         WHERE age > 18
    //         GROUP BY country
    //         HAVING COUNT(*) > 1
    //         ORDER BY id DESC
    //         LIMIT 10
    //         OFFSET 5
    //     SQL;
    // }

   

}