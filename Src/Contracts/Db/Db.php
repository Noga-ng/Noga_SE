<?php
namespace Noga\Contracts\Db;

use Generator;
use PDO;
use PDOStatement;

interface Db{

     /**
      * Summary of connect
      * @return PDO|null
      */
     public function connect():PDO|null;

     /**
      * Summary of disconnect
      * @return null
      */
     public function disconnect();

     /**
      * Summary of execute
      * @param string $sql
      * @param array $params
      * @return bool|PDOStatement
      */
     public function execute(string $sql,array $params = []):bool|PDOStatement;

     /**
      * Summary of One
      * @param string $sql
      * @param array $params
      * @param int $fetchMode
      * @return mixed
      */
     public function One(string $sql,array $params = [],int $fetchMode = PDO::FETCH_OBJ);

     /**
      * Summary of All
      * @param string $sql
      * @param array $params
      * @param int $fetchMode
      * @return array
      */
     public function All(string $sql, array $params = [],int $fetchMode = PDO::FETCH_OBJ):array;

     /**
      * Summary of stream
      * @param string $sql
      * @param array $params
      * @param int $fetchMode
      * @return Generator
      */
     public function stream(string $sql, array $params = [],int $fetchMode = PDO::FETCH_OBJ):Generator;

      /**
       * Summary of lastId
       * @return bool|string
       */
      public function lastId():bool|string;

      /**
       * Summary of create
       * @param string $sql
       * @return bool|PDOStatement
       */
      public function create(string $sql):bool|PDOStatement;

      /**
       * Summary of totransaction
       * @param callable $callback
       * @param object $object
       * @return mixed
       */
      public function toTransaction(callable $callback,object $object):mixed;
}