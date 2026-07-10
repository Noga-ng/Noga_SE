<?php
namespace Noga\Tests\Units\Builder\Clauses;

use Noga\Noga;
use Noga\Tests\Units\Builder\QueryTest;


/**
 * Summary of ClauseConditionTest
 * 
 * Tout les params sont passés par la normalisation pour avoir une test correcte 
 * params hashé aleatoire : :wh_555b97f3_id
 * normalisation : :wh_values
 */
class ClauseConditionTest extends QueryTest{

    public function testClauseWhere(){
        $where = Noga::table("users")->where(["id"=>12]);
        $expect = [':wh_12'=>12];

        $sql = <<<SQL
        SELECT * FROM users WHERE id = :wh_
        SQL;

        $this->assertSqlEquals($sql,$where);
        $this->assertSqlParams($expect,$where);
    }

    public function testClauseWhereMultiple(){

        $where = Noga::table("users")->where(["id"=>12,'noms'=>'noga']);
        
        $expect = [':wh_12'=>12,':wh_noga'=>'noga'];

        $sql = <<<SQL
        SELECT * FROM users WHERE id = :wh_ AND noms = :wh_
        SQL;

        $this->assertSqlEquals($sql,$where);

        $this->assertSqlParams($expect,$where);
    }

    public function testClauseWhereIsNull(){
        $sql = Noga::table("users")->isNull('id');
        $expected = <<<SQL
        SELECT *  FROM users WHERE id IS NULL
        SQL;

        $this->assertSqlEquals($expected,$sql);
    }

     public function testClauseWhereIsNotNull(){
        $sql = Noga::table("users")->isNotNull('id');
        $expected = <<<SQL
        SELECT *  FROM users WHERE id IS NOT NULL
        SQL;

        $this->assertSqlEquals($expected,$sql);
    }

    public function testClauseWhereOr(){
        $sql = Noga::table("users")->whereOr(["id"=>12,"noms"=>"noga"]);
        $expect = <<<SQL
            SELECT * FROM users  WHERE (id = :whOr_ OR noms = :whOr_)
        SQL;

        $this->assertSqlEquals($expect,$sql,'whOr');

        $params = [":whOr_12"=>12,":whOr_noga"=>"noga"];

        $this->assertSqlParams($params,$sql,'whOr');
    }


    public function testWhereLike(){
        $sql = Noga::table("users")->whereLike(["id"=>12,"noms"=>"noga"]);
        
        $params = [":LIKE_12"=>"%12%",":LIKE_noga"=>"%noga%"];

        $expect = <<<SQL
            SELECT * FROM users  WHERE (id LIKE :LIKE_ OR noms LIKE :LIKE_)
        SQL;

        $this->assertBuilderSql($expect,$sql,'LIKE');

        $this->assertSqlParams($params,$sql,'LIKE');

    }


}