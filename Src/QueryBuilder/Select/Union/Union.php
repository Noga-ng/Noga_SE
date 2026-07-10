<?php
namespace Noga\QueryBuilder\Select\Union;

use Noga\QueryBuilder\Builder;
use Noga\QueryBuilder\Select\Select;
class Union
{
    public array $unions = [];
    protected array $table = [];
    protected array $columns = [];
    protected array $conditions = [];
    protected array $params = [];
    protected array $rows = [];
    protected array $cols = [];
    protected bool $distinct = false;
    protected array $groups = [];

    protected ?Builder $clauseBuilder = null;
    private ?Select $sql = null;

    public function __construct()
    {
       $this->sql = new Select();
       $this->unions = [];
       
    }

    public function instance(array $cols,?bool $distinct = false):static{
             $this->cols = $cols;
             $this->distinct = $distinct;
        return $this;
    }
    public function getUnion(bool $all = false):array
    { 
        $all = $all ? "ALL":"";
        $sql = "";
        
        $col = !empty($this->columns) ? $this->columns : $this->cols;
        $cols = !empty($col) ? $col : ["*"];
        $dist = $this->distinct ? "DISTINCT":"";

        $group = !empty($this->group) ? \implode(',',$this->groups) : "";

        foreach($this->table ?? [] as $table){
            $sql .= " UNION {$all}  SELECT {$dist} ".implode(",",$cols)." FROM {$table} {$group} ";
        }

        if(!empty($this->rows)){
            foreach($this->rows as $row){
                $sql .= " UNION {$all}  $row ";
            }
        }
        
        return [$sql,$this->params];
    }

    /**
     * Summary of table
     * @param array $array
     * @return static
     */
    public function from(string ...$array):static{
        $this->table = $array;
        return $this;
    }

    /**
     * Summary of groupBy
     * @param array $array
     * @return static
     */
    public function groupBy(array $array):static{
        $this->groups[] = $array;
        return $this;
    }
    /**
     * Summary of select
     * @param array<string> $columns
     * @return static
     */
    public function select(string ...$columns):static{
        $this->columns = $columns;
        return $this;
    }

    /**
     * Summary of distinct
     * @param bool $distinct
     * @return static
     */
    public function distinct(bool $distinct = false):static{
        $this->distinct = $distinct;
        return $this;
    }

    public function add(array $row):Union{
        $state = [];
      foreach($row as $r){
        if(\is_callable($r) || $r instanceof Select){
            $this->rows[] = $r->getQuery();
            $this->params = \array_merge($this->params,$r->getParams());

        }else if(\is_string($r)){
            $this->rows[] = $r;
            $state[] = $this->rows;
        }
      }

        return $this;
    }
}
