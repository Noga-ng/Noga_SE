<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Delete;

use Noga\Contracts\Delete\DeleteInt;
use PDOException;
use PDOStatement;
use Noga\Traits\Condition;
use Noga\Traits\DbTrait;

final class Delete implements DeleteInt
{
    use Condition;
    use DbTrait;
    private ?DeleteState $state = null;
    public function __construct(string $table)
    {
       $this->state = new DeleteState('DELETE');
       $this->state->table = $table;  
       $this->state->driver = $this->getDriver();
    }

    public static function table(string $table):Delete{
        return clone new static($table);
    }

    /**
     * Summary of limit
     * @param int $limit
     * @return static
     */
    public function limit(int $limit):static{
        $this->state->limit = $limit;
        return $this;
    }

    private function compile():string{
        $this->state->condition = $this->conditions;
        $this->state->params = $this->params;
       return DeleteCompiler::toSql($this->state);
    }

    public function getQuery():string{
        return $this->compile();
    }

    public function viewState():array{
        $this->compile();
        return $this->state->toArray();
    }

    public function exec():bool|PDOStatement{
        $this->stmt = $this->db()
        ->execute($this->compile(),$this->params);

        if(!$this->stmt) throw new PDOException("Error : ".$this->stmt->errorInfo());

        return $this->stmt;
    }



}
