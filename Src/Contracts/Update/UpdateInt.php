<?php
namespace Noga\Contracts\Update;

use Noga\QueryBuilder\Crud\Update\Update;
use PDOStatement;

interface UpdateInt{
        /**
         * Summary of table
         * @param string $table
         * @return Update
         */
        public static function table(string $table):Update;

        /**
         * Summary of set
         * @param array $cols
         * @return Update
         */
        public function set(array $cols = []): Update;

        /**
         * Summary of getQuery
         * @return string
         */
        public function getQuery():string;

        /**
         * Summary of viewState
         * @return array
         */
        public function viewState():array;

        /**
         * Summary of exec
         * @return bool|PDOStatement
         */
        public function exec():bool|PDOStatement;
}