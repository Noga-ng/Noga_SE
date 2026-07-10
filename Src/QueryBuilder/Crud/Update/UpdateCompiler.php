<?php
namespace Noga\QueryBuilder\Crud\Update;

final class UpdateCompiler
{
    private string $sql = "";
    public function __construct(private UpdateState $state)
    {
        $set       = implode(',', $this->state->set);
        $condition = implode(' AND ', $this->state->conditions);
        $this->sql = "UPDATE {$this->state->table} ";
        $this->sql .= " SET  {$set} ";
        if (empty($this->state->conditions)) throw new \RuntimeException(" cannot use method update if conditions is empty ");
        $this->sql .= " WHERE {$condition} ";
    }

    public static function toSql(UpdateState $state): string
    {
        $instance = new static($state);
        return $instance->sql;
    }

}
