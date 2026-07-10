<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Select\Join;
use InvalidArgumentException;
use Noga\QueryBuilder\Select\Select;

class Join
{
    protected array $joins = [];
    protected string $table = "";
    protected string $type = "";
    protected string $as = "";
    protected array $on = [];
    protected array $params = [];
    protected string $sql = ""; 
    protected ?Select $req = null;

    public function __construct()
    {
        $this->params = [];
        $this->req = new Select();
    }

    /**
     * Summary of type
     * @param string $type
     * @return static
     */
    public function type(string $type):static{
        $this->type = \strtoupper($type);
        return $this;
    }
    /**
     * Summary of table
     * @param callable|Select|string $table
     * @return static
     */
    public function table(string|Select|callable $table):static{
      
        if(\is_string($table)){
              $this->table = $table;

        }else if(\is_callable($table) || $table instanceof Select){

          $sub = $table instanceof Select ? $table : $table($this->req);
           if(!$sub instanceof Select) 
            throw new InvalidArgumentException("Error must be return Sql instance");

          $this->table = "(".$sub->getQuery().")";

          $this->params = \array_merge($this->params,$sub->getParams() ?? []);
        }

        return $this;
       
    }

    /**
     * Summary of as
     * @param string $alias
     * @return static
     */
    public function as(string $alias):static{
        $this->as = $alias;
        return $this;
    }

    /**
     * Summary of on
     * @param string $cols1
     * @param string $cols2
     * @param string $comparator
     * @return static
     */
    public function on(string $cols1,string $cols2,string $comparator = "="):static{
        $this->on[] = "{$cols1} {$comparator} {$cols2}";

        return $this;
    }

    /**
     * Summary of andOn
     * @param string $cols1
     * @param string $cols2
     * @param string $comparator
     * @return static
     */
    public function andOn(string $cols1,string $cols2,string $comparator = "="):static{
        $this->on[] = "{$cols1} {$comparator} {$cols2}";
        return $this;
    }

   public function getJoin(string $type):array
{
    $this->type = $type;
    $sql = " ".PHP_EOL." {$this->type} JOIN {$this->table}";

    if ($this->as !== "") {
        $sql .= " AS {$this->as}";
    }

    if (!empty($this->on)) {
        $sql .= " ON ".implode(' AND ',$this->on)."";
    }


    return [$sql, $this->params];
}


}
