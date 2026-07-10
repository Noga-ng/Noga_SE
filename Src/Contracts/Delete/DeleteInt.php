<?php
namespace Noga\Contracts\Delete;

use Noga\QueryBuilder\Crud\Delete\Delete;
use PDOStatement;

interface DeleteInt{
    /**
     * Summary of table
     * @param string $table
     * @return Delete
     */
    public static function table(string $table):Delete;

    /**
     * Summary of limit
     * @param int $limit
     * @return static
     */
    public function limit(int $limit):static;

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