<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Insert;

final class InsertCompiler{
    private string $sql = "";

    public function __construct(private InsertState $state)
    {
        $cols = implode(',',$this->state->columns);
        $val = implode(',',$this->state->bind);

        $this->sql = "INSERT INTO {$this->state->table}(";   
        $this->sql .="{$cols}) ";
        $this->sql .= " VALUES({$val})";
    }

    public static function toSql(InsertState $state):string{
       $instance = new static($state);
        return $instance->sql;
    }
}