<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Update;

use PDOException;
use PDOStatement;
use Noga\Core\BindHashing;
use Noga\Noga;
use Noga\Traits\Condition;
use Noga\Traits\DbTrait;
/**
 * Summary of CRUDUpdate
 */
class Update
{
    use Condition;
    use DbTrait;

    private ?UpdateState $state = null;
    
    public function __construct(string $table)
    {
       $this->state = new UpdateState('UPDATE');
       $this->state->table = $table;
       $this->driver = Noga::get('driver');
       $this->state->driver = $this->driver;
    }

    /**
     * Summary of table
     * @param string $table
     * @return \Noga\QueryBuilder\Crud\Update\Update
     */
    public static function table(string $table):Update{
        return clone new static($table);
    }

    /**
     * Summary of set
     * @param array $cols colonne en table
     * @return Update
     */
    public function set(array $cols = []): Update
    {
        $clone = clone $this;
        foreach ($cols ?? [] as $k => $v) {
            $key                       = BindHashing::hash("set",$k);
            $clone->state->set[] = "$k = $key";
            $clone->params[$key] = $v;
        }

        return $clone;
    }

    /**
     * Summary of compile
     * @return string
     */
    private function compile():string{
        $this->state->conditions = array_merge($this->state->conditions,$this->conditions);
        $this->state->params = array_merge($this->state->params,$this->params);
        return UpdateCompiler::toSql($this->state);
    }

    /**
     * Summary of getQuery
     * @return string
     */
    public function getQuery():string{
        return $this->compile();
    }

    /**
     * Summary of viewState
     * @return array
     */
    public function viewState():array{
        $this->compile();
        return $this->state->toArray();
    }

    /**
     * Summary of exec
     * @throws PDOException
     * @return PDOStatement
     */
    public function exec():bool|PDOStatement{
        $this->stmt = $this->db()
        ->execute($this->compile(),$this->state->params);
        if(!$this->stmt) throw new PDOException("Error : ".$this->stmt->errorInfo());
        return $this->stmt;
    }



}
