<?php
namespace Noga\Tests;

use PHPUnit\Framework\TestCase;

abstract class QueryTest extends TestCase
{
    protected function assertSqlEquals(string $expected, object $actual,string $prefix = 'wh'): void
    {
        $this->assertSame(
            self::normalizeSql($expected,$prefix),
            self::normalizeSql($actual->getQuery(),$prefix)
        );
    }

   protected function assertBuilderSql(string $expected,object $builder,$prefix = 'wh'): void
{
    $this->assertSqlEquals(
        $expected,
        $builder,
        $prefix
    );
}

    protected function assertSqlParams(array $expected,object $builder,string $prefix ='wh'):void{
        $this->assertSame(
            $expected,
            self::normalizeParams($builder->getParams(),$prefix)
        );
    }


    private static function normalizeSql(string $sql,string $prefix): string {
            $sql = preg_replace('/\s+/', ' ', trim($sql));
            $sql = preg_replace('/\(\s+/', '(', $sql);
            $sql = preg_replace('/\s+\)/', ')', $sql);

            $sql = preg_replace(
            "#:$prefix\_[a-f0-9]+(?:_[a-z]+)?#", 
            ":{$prefix}_",
             $sql);

            return $sql;
    }

    private static function normalizeParams(array $params,string $prefix):array{
        $param = [];
        foreach($params as $k =>$v){
            $key = self::normalizeSql($k,$prefix).$v;
            $param[str_replace('%','',$key)] = $v;
        }
        return $param;
    }
}