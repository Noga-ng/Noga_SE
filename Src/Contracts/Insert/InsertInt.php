<?php
namespace Noga\Contracts\Insert;

use Noga\QueryBuilder\Crud\Insert\Insert;

interface InsertInt{

    /**
     * Summary of table
     * @param string $table
     * @return Insert
     */
    public function table(string $table):Insert;

    /**
     * Summary of columns
     * @param string[] $columns
     * @return Insert
     */
    public function columns(string ...$columns):Insert;

    /**
     * Summary of values
     * @param string|int|bool $values
     * @return Insert
     */
    public function values(string|int|bool ...$values):Insert;

    /**
     * Summary of from
     * @param string $file
     * @return  Insert
     */
    public function from(string $file):Insert;

    /**
     * Summary of except
     * @param string[] $columns
     * @return Insert
     */
    public function except(string ...$columns):Insert;

    /**
     * Summary of take
     * @return Insert
     */
    public function take():Insert;

    /**
     * Summary of exec
     * @return string|bool
     */
    public function exec():string|bool;

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
}